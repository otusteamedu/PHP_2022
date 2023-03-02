<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Bank\DealStateMapperResolver;
use App\Domain\Entity\Deal;
use App\Domain\Entity\DealHistory;
use Doctrine\ORM\EntityManagerInterface;
use new\Domain\Enum\Bank\Common\Enum\BankApplicationStateInterface;
use new\Domain\Enum\NewLK\DealState;

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
        $dealStateMapper = DealStateMapperResolver::getMapperByBank($deal->getBank(), $deal);
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
