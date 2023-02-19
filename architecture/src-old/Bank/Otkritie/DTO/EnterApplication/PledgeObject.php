<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use Money\Money;

class PledgeObject
{
    /**
     * Стоимость объекта недвижимости в рублях
     */
    public Money $EstimatedCost;

    public function __construct(Money $EstimatedCost)
    {
        $this->EstimatedCost = $EstimatedCost;
    }
}
