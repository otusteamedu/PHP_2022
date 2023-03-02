<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Gateway\Repository\DealRepositoryInterface;
use App\Domain\UseCase\MainBorrowerDetector;
use App\Domain\Entity\Bank;
use App\Domain\Entity\Deal;
use Doctrine\ORM\EntityManagerInterface;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Ramsey\Uuid\Uuid;

class DealCreator
{
    public function __construct(
        private readonly DealRepositoryInterface $dealRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function getOrCreateDealByQuestionnaireAndBank(DeliveryFullQuestionnaire $questionnaire, Bank $bank): Deal
    {
        $deal = $this->dealRepository->find($questionnaire->dealId);
        if (\is_null($deal)) {
            $deal = new Deal(
                Uuid::fromString($questionnaire->dealId),
                Uuid::fromString($questionnaire->applicationId),
                $bank
            );
            $deal->setApplicationSerial($questionnaire->applicationSerial);
            $deal->setBorrowerFullName(MainBorrowerDetector::getMainBorrower($questionnaire)->name->toString());

            $this->entityManager->persist($deal);
            $this->entityManager->flush();
        }

        return $deal;
    }
}
