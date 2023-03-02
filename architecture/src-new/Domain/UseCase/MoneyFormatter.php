<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * Служит для отображения сумм с типом Money в нормальном формате
 */
class MoneyFormatter
{
    /**
     * Возвращает сумму в десятичном формате, например для 100 рублей будет возвращено "100.00"
     */
    public static function decimalFormat(Money $money): string
    {
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }
}
