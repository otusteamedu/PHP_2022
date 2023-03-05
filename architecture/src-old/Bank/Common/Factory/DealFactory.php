<?php

declare(strict_types=1);

namespace App\Bank\Common\Factory;

use App\Entity\Bank;
use App\Entity\Deal;
use App\Repository\DealRepository;
use App\Service\QuestionnaireService;
use Doctrine\ORM\EntityManagerInterface;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Ramsey\Uuid\Uuid;

class DealFactory
{
    public function __construct(
        private readonly DealRepository $dealRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function getDealByQuestionnaireAndBank(DeliveryFullQuestionnaire $questionnaire, Bank $bank): Deal
    {
        $deal = $this->dealRepository->find($questionnaire->dealId);
        if (\is_null($deal)) {
            $deal = new Deal(
                Uuid::fromString($questionnaire->dealId),
                Uuid::fromString($questionnaire->applicationId),
                $bank
            );
            $deal->setApplicationSerial($questionnaire->applicationSerial);
            $deal->setBorrowerFullName(QuestionnaireService::getMainBorrower($questionnaire)->name->toString());

            if (
                $bank->getInternalId()->toString() === Bank::UUID_DOMRF
                || $bank->getInternalId()->toString() === Bank::UUID_GPB
                || $bank->getInternalId()->toString() === Bank::UUID_MKB
            ) {
                $deal->setDeliveryFullQuestionnaire($questionnaire);
            }
            $this->entityManager->persist($deal);
            $this->entityManager->flush();
        } elseif (
            $bank->getInternalId()->toString() === Bank::UUID_DOMRF
            || $bank->getInternalId()->toString() === Bank::UUID_MKB
        ) {
            $deal->setDeliveryFullQuestionnaire($questionnaire);
            $this->entityManager->flush();
        }

        return $deal;
    }
}
