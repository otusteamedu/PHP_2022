<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

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
