<?php

namespace App\Domain\Enum;

enum StatusEnum: string
{
    case IN_QUEUE = 'in_queue';
    case READY = 'ready';
    case WAITING = 'waiting';
}
