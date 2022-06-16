<?php

namespace Patterns\App\Application\Service;

use Patterns\App\Application\QueryBuilderInterface;
use Patterns\App\Application\Repository;
use Patterns\App\Domain\Entity\SumMoneyEntity;
use WS\Utils\Collections\CollectionFactory;

class AtmService
{
    private const NOMINAL_50 = '50';
    private const NOMINAL_100 = '100';
    private const NOMINAL_500 = '500';
    private const NOMINAL_1000 = '1000';

    public function __construct(
        private QueryBuilderInterface $queryBuilder,
        private Repository $repository,
    ) {
    }

    public function put(array $money): bool
    {
        /** @var SumMoneyEntity $savedMoney */
        $savedMoney = $this->repository->findById(1);

        $fiftyBanknoteCount = $this->getBanknoteCount(self::NOMINAL_50, $money);
        $hundredBanknoteCount = $this->getBanknoteCount(self::NOMINAL_100, $money);
        $fiveHundredBanknoteCount = $this->getBanknoteCount(self::NOMINAL_500, $money);
        $thousandBanknoteCount = $this->getBanknoteCount(self::NOMINAL_1000, $money);

        $sumMoney = new SumMoneyEntity(
            id: 1,
            fifty_banknote_count: $fiftyBanknoteCount + $savedMoney->getFiftyBanknoteCount(),
            hundred_banknote_count: $hundredBanknoteCount + $savedMoney->getHundredBanknoteCount(),
            five_hundred_banknote_count: $fiveHundredBanknoteCount + $savedMoney->getFiveHundredBanknoteCount(),
            thousand_banknote_count: $thousandBanknoteCount + $savedMoney->getThousandBanknoteCount(),
        );

        return $this->queryBuilder
            ->table('money')
            ->update($sumMoney);
    }

    private function getBanknoteCount(string $nominal, array $money): int
    {
        return CollectionFactory::from($money)
            ->stream()
            ->filter(function ($item) use ($nominal) {
                return (string)$item === $nominal;
            })
            ->getCollection()
            ->size();
    }
}