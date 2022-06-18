<?php

namespace Patterns\App\Infrastructure\Repository;

use Patterns\App\Application\QueryBuilderInterface;
use Patterns\App\Application\Repository;
use Patterns\App\Domain\Entity\SumMoneyEntity;
use WS\Utils\Collections\CollectionFactory;

class AtmRepository implements Repository
{
    public function __construct(
        private QueryBuilderInterface $queryBuilder
    ) {
    }

    public function findById(int $id): ?SumMoneyEntity
    {
        $result = $this->queryBuilder
            ->select([
                'id',
                'fifty_banknote_count',
                'hundred_banknote_count',
                'five_hundred_banknote_count',
                'thousand_banknote_count'
            ])
            ->from('money')
            ->where('id = ' . $id)
            ->getQuery()
            ->getResult();

        $money = CollectionFactory::from($result)->stream()->findFirst();

        return new SumMoneyEntity(
            id: 1,
            fifty_banknote_count: (int)$money['fifty_banknote_count'],
            hundred_banknote_count: (int)$money['hundred_banknote_count'],
            five_hundred_banknote_count: (int)$money['five_hundred_banknote_count'],
            thousand_banknote_count: (int)$money['thousand_banknote_count'],
        );
    }
}