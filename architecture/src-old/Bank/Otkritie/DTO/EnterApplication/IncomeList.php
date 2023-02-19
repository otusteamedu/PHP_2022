<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Информация о доходах.
 */
class IncomeList
{
    /**
     * @var Financial[]
     */
    public array $Financial;

    /**
     * @param Financial[] $Financial
     */
    public function __construct(array $Financial)
    {
        $this->Financial = $Financial;
    }
}
