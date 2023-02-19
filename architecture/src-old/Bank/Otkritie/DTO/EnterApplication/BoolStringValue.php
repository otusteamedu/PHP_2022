<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 *  Булевые значения в виде строки
 */
enum BoolStringValue: string
{
    case TRUE = 'true';
    case FALSE = 'false';
}
