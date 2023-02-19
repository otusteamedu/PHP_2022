<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

use App\Bank\Otkritie\DTO\SystemCode;

class Id
{
    /**
     * В Value хранится сам идентификатор
     */
    public string $Value;

    public SystemCode $SystemCode;
}
