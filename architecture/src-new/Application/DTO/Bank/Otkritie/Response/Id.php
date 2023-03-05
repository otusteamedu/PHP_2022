<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

use App\Application\DTO\Bank\Otkritie\SystemCode;

class Id
{
    /**
     * В Value хранится сам идентификатор
     */
    public string $Value;

    public SystemCode $SystemCode;
}
