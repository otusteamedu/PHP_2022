<?php

declare(strict_types=1);

namespace App\Service;

use App\Bank\Common\Enum\BankApplicationStateInterface;
use App\Bank\Common\Factory\DealStateMapperFactory;
use App\Entity\Deal;
use App\Entity\DealHistory;
use App\NewLK\Enum\DealState;
use Doctrine\ORM\EntityManagerInterface;

class DealStateManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function setState(
        Deal $deal,
        BankApplicationStateInterface $newBankApplicationState,
        string $comment = ''
    ): void {
        $dealStateMapper = DealStateMapperFactory::getMapperByBank($deal->getBank(), $deal);
        $newDealState = $dealStateMapper->getByBankApplicationState($newBankApplicationState);

        if ($newDealState !== $deal->getState()) {
            $this->createHistoryItem($deal, $newDealState, $comment);
        }

        $deal->setState($newDealState);
    }

    private function createHistoryItem(Deal $deal, DealState $state, string $comment): void
    {
        $item = new DealHistory($deal, $state, $comment);
        $this->entityManager->persist($item);
    }
}
