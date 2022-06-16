<?php

namespace Patterns\App\Application\Service;

use Patterns\App\Application\Repository;
use Patterns\App\Domain\Entity\SumMoneyEntity;

class MoneyIssuingLargeService implements MoneyIssuingService
{
    private const NOMINAL_500 = 500;
    private const NOMINAL_1000 = 1000;

    public function __construct(
        private Repository $repository,
    ) {
    }

    public function giveOut(int $sum): array
    {
        /** @var SumMoneyEntity $savedMoney */
        $savedMoney = $this->repository->findById(1);

        $thousandCount = $sum >= self::NOMINAL_1000 ? intdiv($sum, self::NOMINAL_1000) : 0;
        $thousandCount = $thousandCount > $savedMoney->getThousandBanknoteCount()
            ? $savedMoney->getThousandBanknoteCount()
            : $thousandCount;
        $sum -= $thousandCount * self::NOMINAL_1000;

        $fiveHundredCount = $sum >= self::NOMINAL_500 ? intdiv($sum, self::NOMINAL_500) : 0;
        $fiveHundredCount = $fiveHundredCount > $savedMoney->getFiveHundredBanknoteCount()
            ? $savedMoney->getFiveHundredBanknoteCount()
            : $fiveHundredCount;
        $sum -= $fiveHundredCount * self::NOMINAL_500;

        if ($sum > 0) {
            throw new \Exception('Невозможно выдать указанную сумму');
        }

        return [
            'fiveHundredCount' => $fiveHundredCount,
            'thousandCount' => $thousandCount,
        ];
    }
}