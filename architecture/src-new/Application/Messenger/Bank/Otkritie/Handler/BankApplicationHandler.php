<?php

declare(strict_types=1);

namespace App\Application\Messenger\Bank\Otkritie\Handler;

use App\Application\DTO\Bank\Otkritie\Response\Main as EnterApplicationResponse;
use App\Application\DTO\Bank\Otkritie\Response\Status;
use App\Application\DTO\Bank\Otkritie\SystemCode;
use App\Application\EventSystem\Event\DealSentToBank;
use App\Application\EventSystem\Event\DealStateChangedEvent;
use App\Application\Exception\InvalidValueException;
use App\Application\Gateway\Bank\OtkritieApiGatewayInterface;
use App\Application\Gateway\NewLK\DocumentDownloaderInterface;
use App\Application\Gateway\Repository\BankRepositoryInterface;
use App\Application\Gateway\Repository\DocumentRepositoryInterface;
use App\Application\UseCase\Bank\Otkritie\QuestionnaireToApplicationConverter;
use App\Application\UseCase\Bank\Otkritie\RequestPayloadGenerator;
use App\Application\UseCase\DealCreator;
use App\Application\UseCase\DealStateManager;
use App\Application\UseCase\ProfileCreator;
use App\Domain\Entity\Bank;
use App\Domain\Entity\Deal;
use App\Domain\Entity\DealOtkritie;
use App\Domain\Entity\Document;
use App\Domain\Entity\Profile;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Dvizh\BankBusDTO\FileData;
use Dvizh\BankBusDTO\NewBusPerson;
use GuzzleHttp\Exception\ClientException;
use App\Domain\Enum\Bank\Otkritie\OtkritieApplicationState;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Handler для SymfonyMessenger для обработки заявки в банк Открытие
 */
class BankApplicationHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface              $entityManager,
        private readonly DealCreator                         $dealCreator,
        private readonly ProfileCreator                      $profileCreator,
        private readonly BankRepositoryInterface             $bankRepository,
        private readonly DocumentRepositoryInterface         $documentRepository,
        private readonly RequestPayloadGenerator             $requestPayloadGenerator,
        private readonly QuestionnaireToApplicationConverter $questionnaireConverter,
        private readonly OtkritieApiGatewayInterface         $bankApiGateway,
        private readonly DocumentDownloaderInterface         $documentDownloader,
        private readonly DealStateManager                    $dealStateManager,
        private readonly EventDispatcherInterface            $dispatcher,
        private readonly LockFactory                         $lockFactory
    ) {
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(BankApplicationMessage $message): void
    {
        // Т.к. отправка в Открытие занимает длительное время, поэтому, чтобы во время отправки сделки, не началась
        // параллельная отправка этой сделки (например, менеджер два раза кнопку нажал), ставим локи
        $lock = $this->lockFactory->createLock('send_deal_' . $message->getQuestionnaire()->dealId);
        if (!$lock->acquire()) {
            return;
        }

        /** @var Bank $bank */
        $bank = $this->bankRepository->find(Bank::UUID_OTKRITIE);
        $deal = $this->dealCreator->getOrCreateDealByQuestionnaireAndBank($message->getQuestionnaire(), $bank);
        $documents = $this->getPersonsDocuments(
            $message->getQuestionnaire()->borrowerQuestionnaire->persons,
            $deal,
            $message->getQuestionnaire()->fileCollection
        );

        $application = $this->questionnaireConverter->getApplicationByQuestionnaire(
            $message->getQuestionnaire(),
            $deal,
            $documents
        );

        $requestPayload = $this->requestPayloadGenerator->createEnterApplicationPayloadFile(
            $application,
            $deal->getDocuments()
        );

        try {
            $response = $this->bankApiGateway->enterApplication($requestPayload);
        } catch (ClientException $e) {
            $this->handleClientException($e, $deal, $message->getQuestionnaire());
            $lock->release();
            return;
        } finally {
            $isInitial = is_null($deal->getState());
            $this->dispatcher->dispatch(new DealSentToBank($deal, $isInitial));
        }

        if (intval($response->OpenAPI->Status->StatusCode) === Status::STATUS_CODE_SUCCESS) {
            $this->saveEntities($deal, $response);
            $additionalNotificationMessages = [];
            $dealOtkritie = $deal->getDealOtkritie();
            if (!\is_null($dealOtkritie)) {
                $additionalNotificationMessages[] = 'Короткий номер заявки в Открытии: ' . $dealOtkritie->getShortId();
            }
            $this->dispatcher->dispatch(new DealStateChangedEvent($deal, OtkritieApplicationState::SENT, '', $additionalNotificationMessages));
            $lock->release();
            return;
        }

        $errorMessage = $response->OpenAPI->Status->Msg ?? '';
        $this->saveError($deal, $errorMessage);
        $dealOtkritie = $deal->getDealOtkritie();
        if (!\is_null($dealOtkritie)) {
            $errorMessage .= PHP_EOL . 'Короткий номер заявки в Открытии: ' . $dealOtkritie->getShortId();
        }
        $lock->release();
        throw new \RuntimeException($errorMessage);
    }

    /**
     * @param NewBusPerson[] $persons
     * @param FileData[] $rewritingFilesData Новые документы, которые нужны для доработки.
     * @return array<string, Collection<string, Document>>
     * @throws \Throwable
     */
    private function getPersonsDocuments(array $persons, Deal $deal, array $rewritingFilesData): array
    {
        $documents = [];
        foreach ($persons as $person) {
            $profile = $this->profileCreator->getProfileByClientIdAndDeal($person->clientId, $deal);

            if (!is_null($deal->getExternalId()) && count($rewritingFilesData) !== 0) {
                $customerFilesData = $this->getFilesForRewriting($person->customerFilesData, $rewritingFilesData);
            } else {
                $customerFilesData = $person->customerFilesData;
            }

            $personDocuments = $this->documentDownloader->getProfileDocuments(
                $deal,
                $profile,
                $customerFilesData,
                true
            );

            $documents[$person->clientId] = $this->modifyDocuments($deal, $profile, $personDocuments);
        }

        return $documents;
    }

    /**
     * Получает на вход массив файлов участника и массив файлов, которые нужно отправить на доработку. Отфильтровывает
     * лишние файлы, чтобы при отправке в банк к пользователю были прикреплены только новые документы
     * @param FileData[] $customerFilesData
     * @param FileData[] $rewritingFilesData
     * @return FileData[]
     */
    private function getFilesForRewriting(array $customerFilesData, array $rewritingFilesData): array
    {
        $rewritingFilesIds = [];
        foreach ($rewritingFilesData as $fileData) {
            $rewritingFilesIds[] = $fileData->uuid;
        }

        $result = [];
        foreach ($customerFilesData as $fileData) {
            if (in_array($fileData->uuid, $rewritingFilesIds)) {
                $result[] = $fileData;
            }
        }

        return $result;
    }


    /**
     * Дополнительные модификации документов, например, добавление external_id при доработке
     * @param Collection<string, Document> $documents
     * @return Collection<string, Document>
     */
    private function modifyDocuments(Deal $deal, Profile $profile, Collection $documents): Collection
    {
        $externalId = $profile->getExternalId();
        if (is_null($externalId)) {
            return $documents;
        }

        /** @var Document[] $documentsForRevision */
        $documentsForRevision = $this->documentRepository->findBy([
            'comment' => sprintf(
                'доработка deal_uuid=%s profile_external_id=%s',
                $deal->getInternalId()->toString(),
                $externalId
            )
        ]);
        if (count($documentsForRevision) === 0) {
            return $documents;
        }

        foreach ($documents as $document) {
            $d = array_shift($documentsForRevision);
            $document->setExternalId($d->getExternalId());
            $this->entityManager->persist($document);
            $this->entityManager->remove($d);

            if (count($documentsForRevision) === 0) {
                break;
            }
        }
        $this->entityManager->flush();

        return $documents;
    }

    /**
     * Сохранение заявки, участников и их идентификаторов в Открытии в БД
     */
    private function saveEntities(Deal $deal, EnterApplicationResponse $response): void
    {
        $this->dealStateManager->setState($deal, OtkritieApplicationState::SENT);
        $deal->setComment($response->OpenAPI->Status->Msg);

        $externalUid = null;
        $externalShortId = null;
        foreach ($response->OpenAPI->Application->IdList->Id as $id) {
            if ($id->SystemCode === SystemCode::MSCRM) {
                $externalUid = $id->Value;
            }
            if ($id->SystemCode === SystemCode::CDI) {
                $externalShortId = $id->Value;
            }
        }
        if (\is_null($externalUid) || \is_null($externalShortId)) {
            throw new InvalidValueException(sprintf(
                'Ошибка при получении ответа от Открытия: не передан MSCRM id. Запрос RqID=%s',
                $response->OpenAPI->RqID
            ));
        }

        $deal->setExternalId($externalUid);
        $dealOtkritie = $deal->getDealOtkritie();
        if (\is_null($dealOtkritie)) {
            $dealOtkritie = new DealOtkritie($deal, Uuid::fromString($externalUid), \intval($externalShortId));
            $deal->setDealOtkritie($dealOtkritie);
        }

        $parties = $response->OpenAPI->Application->AgreementList->Agreement->ParticipantList->Party;

        // Костыль, чтобы обрабатывать ответы от Открытия, которые могут иметь разную структуру - Document может быть
        // как объектом Document, так и массивом
        if (!is_array($parties)) {
            $parties = [$parties];
        }
        foreach ($parties as $party) {
            $profileIds = $party->IdList->Id;

            $profileInternalId = null;
            $profileExternalId = null;
            foreach ($profileIds as $id) {
                if ($id->SystemCode === SystemCode::BalancePlatform) {
                    $profileInternalId = $id->Value;
                }
                if ($id->SystemCode === SystemCode::MSCRM) {
                    $profileExternalId = $id->Value;
                }
            }
            if (is_null($profileInternalId) || is_null($profileExternalId)) {
                continue;
            }
            $profile = $this->profileCreator->getProfileByClientIdAndDeal($profileInternalId, $deal);
            $profile->setExternalId($profileExternalId);
            $this->entityManager->persist($profile);
        }

        $this->entityManager->persist($deal);
        $this->entityManager->persist($dealOtkritie);
        $this->entityManager->flush();
    }

    /**
     * Сохранение статуса заявки и описания ошибки
     */
    private function saveError(Deal $deal, string $message = ''): void
    {
        $this->dealStateManager->setState($deal, OtkritieApplicationState::TECHNICAL_ERROR);
        $deal->setComment($message);

        $this->entityManager->persist($deal);
        $this->entityManager->flush();
    }

    private function handleClientException(
        ClientException $e,
        Deal $deal,
        DeliveryFullQuestionnaire $questionnaire
    ): void {
        $bankMessage = $e->getResponse()->getBody()->getContents();
        $additionalNotificationMessages = [];
        $dealOtkritie = $deal->getDealOtkritie();
        if (!\is_null($dealOtkritie)) {
            $additionalNotificationMessages[] = 'Короткий номер заявки в Открытии: ' . $dealOtkritie->getShortId();
        }

        $this->saveError($deal, $bankMessage);

        $this->dispatcher->dispatch(new DealStateChangedEvent(
            $deal,
            OtkritieApplicationState::TECHNICAL_ERROR,
            'Ответ от банка: ' . $bankMessage,
            $additionalNotificationMessages
        ));
    }
}
