<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

use Money\Money;

/**
 * Сумма кредита.
 */
class CreditAmount
{
    /**
     * Сумма в рублях
     */
    public Money $Amount;

    public function __construct(Money $Amount)
    {
        $this->Amount = $Amount;
    }
}
