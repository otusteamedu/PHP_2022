<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use Money\Money;

/**
 * Первоначальный взнос
 */
class InitialFee
{
    /**
     * Сумма первоначального взноса в рублях
     */
    public Money $Amount;

    public function __construct(Money $Amount)
    {
        $this->Amount = $Amount;
    }
}
