<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ProcessStatus
{
    case CREATED;
    case PROCESSING;
    case FINISHED;
    case NOT_FOUND;
}