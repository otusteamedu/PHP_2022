<?php

namespace Patterns\App\Application\Service;

use Patterns\App\Application\Repository;
use Patterns\App\Domain\Entity\SumMoneyEntity;

class MoneyIssuingSmallService implements MoneyIssuingService
{
    private const NOMINAL_50 = 50;
    private const NOMINAL_100 = 100;

    public function __construct(
        private Repository $repository,
    ) {
    }

    public function giveOut(int $sum): array
    {
        /** @var SumMoneyEntity $savedMoney */
        $savedMoney = $this->repository->findById(1);

        $hundredCount = $sum >= self::NOMINAL_100 ? intdiv($sum, self::NOMINAL_100) : 0;
        $hundredCount = $hundredCount > $savedMoney->getHundredBanknoteCount()
            ? $savedMoney->getHundredBanknoteCount()
            : $hundredCount;
        $sum -= $hundredCount * self::NOMINAL_100;

        $fiftyCount = $sum >= self::NOMINAL_50 ? intdiv($sum, self::NOMINAL_50) : 0;
        $fiftyCount = $fiftyCount > $savedMoney->getFiftyBanknoteCount()
            ? $savedMoney->getFiftyBanknoteCount()
            : $fiftyCount;
        $sum -= $fiftyCount * self::NOMINAL_50;

        if ($sum > 0) {
            throw new \Exception('Невозможно выдать указанную сумму');
        }

        return [
            'fiftyCount' => $fiftyCount,
            'hundredCount' => $hundredCount,
        ];
    }
}