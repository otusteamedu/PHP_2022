<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie;

class Id
{
    /**
     * В content хранится сам идентификатор (используется для запросов в банк).
     */
    public string $content;
    /**
     * В Value хранится сам идентификатор (используется в ответах от банка).
     */
    public string $Value;

    public SystemCode $systemCode;
}
