<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ProcessStatus: string
{
    case CREATED = 'created';
    case PROCESSING = 'processing';
    case FINISHED = 'finished';
    case NOT_FOUND = 'not_found';
}