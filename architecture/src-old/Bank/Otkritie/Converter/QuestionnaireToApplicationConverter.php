<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter;

use App\Bank\Otkritie\Converter\Factory\ApplicationOptionListFactory;
use App\Bank\Otkritie\DTO\EnterApplication\Application;
use App\Bank\Otkritie\DTO\EnterApplication\DocumentList;
use App\Bank\Otkritie\DTO\EnterApplication\Main;
use App\Bank\Otkritie\DTO\Id;
use App\Bank\Otkritie\DTO\IdList;
use App\Bank\Otkritie\DTO\EnterApplication\OpenAPI;
use App\Bank\Otkritie\DTO\EnterApplication\ParticipantList;
use App\Bank\Otkritie\DTO\EnterApplication\RegistrationBranch;
use App\Bank\Otkritie\DTO\SystemCode;
use App\Bank\Otkritie\Converter\Factory\AgreementListFactory;
use App\Bank\Otkritie\Converter\Factory\DocumentFactory;
use App\Bank\Otkritie\Converter\Factory\PartyFactory;
use App\Bank\Otkritie\Converter\Factory\ProductFactory;
use App\Entity\Deal;
use App\Entity\Document;
use App\NewLK\Enum\DealState;
use App\Repository\DealRepository;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\Collection;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Dvizh\BankBusDTO\NewBusPerson;
use Dvizh\BankBusDTO\NewBusPersonRole;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class QuestionnaireToApplicationConverter
{
    private DealRepository $dealRepository;
    private ProfileRepository $profileRepository;
    private RouterInterface $router;

    public function __construct(
        DealRepository $dealRepository,
        ProfileRepository $profileRepository,
        RouterInterface $router
    ) {
        $this->dealRepository = $dealRepository;
        $this->profileRepository = $profileRepository;
        $this->router = $router;
    }

    /**
     * @param array<string, Collection<string, Document>> $dealDocuments
     */
    public function getApplicationByQuestionnaire(
        DeliveryFullQuestionnaire $questionnaire,
        Deal $deal,
        array $dealDocuments
    ): Main {
        $applicationIdList = $this->getApplicationIdList($questionnaire);
        $participantList = $this->getParticipantList($questionnaire, $dealDocuments, $deal);

        $agreementList = AgreementListFactory::createByNewBusLoanDataAndParticipantList(
            $questionnaire->borrowerQuestionnaire->loan,
            $participantList
        );

        $product = ProductFactory::createByNewBusLoanTypePurposeAndSystemCode(
            $questionnaire->borrowerQuestionnaire->loan->type,
            $questionnaire->borrowerQuestionnaire->loan->purpose,
            SystemCode::MSCRM
        );

        $registrationBranch = null;
        if (!is_null($questionnaire->bank->office)) {
            $registrationBranch = new RegistrationBranch($questionnaire->bank->office);
        }

        $borrower = $this->getBorrowerFromParticipants($questionnaire->borrowerQuestionnaire->persons);
        if (is_null($borrower)) {
            throw new \RuntimeException(sprintf('"There is no borrowers in deal %s"', $questionnaire->dealId));
        }
        $optionList = ApplicationOptionListFactory::createByQuestionnaire($questionnaire);

        $application = new Application($applicationIdList, $agreementList, $product, $registrationBranch, $optionList);
        $application->Comment = $questionnaire->comment;
        $openAPI = $this->getOpenAPI($application);

        return new Main($openAPI);
    }

    private function getApplicationIdList(DeliveryFullQuestionnaire $questionnaire): IdList
    {
        $dealIDs = [];
        $internalId = new Id();
        $internalId->systemCode = SystemCode::BalancePlatform;
        $internalId->content = $questionnaire->dealId;
        $dealIDs[] = $internalId;

        $deal = $this->dealRepository->find($questionnaire->dealId);
        if (is_null($deal)) {
            return new IdList($dealIDs);
        }
        $dealExternalId = $deal->getExternalId();
        if (!is_null($dealExternalId)) {
            $externalId = new Id();
            $externalId->systemCode = SystemCode::MSCRM;
            $externalId->content = $dealExternalId;
            $dealIDs[] = $externalId;
        }
        return new IdList($dealIDs);
    }

    private function getParticipantList(
        DeliveryFullQuestionnaire $questionnaire,
        array $dealDocuments,
        Deal $deal
    ): ParticipantList {
        $participants = [];
        foreach ($questionnaire->borrowerQuestionnaire->persons as $person) {
            // В Открытие передаем только данные заемщиков и созаемщиков
            if (!in_array($person->role->value, [NewBusPersonRole::BORROWER, NewBusPersonRole::COBORROWER])) {
                continue;
            }

            $personsIds = [];
            $internalPersonId = new Id();
            $internalPersonId->systemCode = SystemCode::BalancePlatform;
            $internalPersonId->content = $person->clientId;
            $personsIds[] = $internalPersonId;

            $profile = $this->profileRepository->find([
                'internal_id' => Uuid::fromString($person->clientId),
                'deal' => $deal
            ]);
            if (!is_null($profile)) {
                $profileExternalId = $profile->getExternalId();
                if (!is_null($profileExternalId)) {
                    $externalPersonId = new Id();
                    $externalPersonId->content = $profileExternalId;
                    $externalPersonId->systemCode = SystemCode::MSCRM;
                    $personsIds[] = $externalPersonId;
                }
            }
            $personIdList = new IdList($personsIds);

            $documents = [];
            $passport = DocumentFactory::createByNewBusPassport($person->passport);
            $documents[] = $passport;
            $profileDocuments = $dealDocuments[$person->clientId] ?? [];
            foreach ($profileDocuments as $profileDocument) {
                $documents[] = DocumentFactory::createByNewBusDocumentEntity($profileDocument);
            }
            $documentList = new DocumentList($documents);

            $participant = PartyFactory::createByPersonIdLIstAndDocuments(
                $person,
                $questionnaire->borrowerQuestionnaire->loan,
                $personIdList,
                $documentList,
                $deal
            );
            $participants[] = $participant;
        }

        return new ParticipantList($participants);
    }

    /**
     * Возвращает заемщика из списка участников
     * @param array<NewBusPerson> $persons
     */
    private function getBorrowerFromParticipants(array $persons): ?NewBusPerson
    {
        foreach ($persons as $person) {
            if (NewBusPersonRole::BORROWER === $person->role->value) {
                return $person;
            }
        }

        return null;
    }

    private function getOpenAPI(Application $application): OpenAPI
    {
        $openAPI = new OpenAPI($application);
        $openAPI->SrcSystemCode = SystemCode::BalancePlatform;
        $openAPI->DstSystemCode = SystemCode::MSCRM;
        $openAPI->RequestDT = new \DateTimeImmutable();
        $openAPI->CallbackURL = 'https:' . $this->router->generate(
            'otkritie.set_app_decision',
            [],
            UrlGeneratorInterface::NETWORK_PATH
        );

        $openAPI->RqID = uniqid();

        return $openAPI;
    }
}
