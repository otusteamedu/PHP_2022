<?php

declare(strict_types=1);

namespace Src\Application\Contracts\Infrastructure\Queues;

interface QueueConsumerGateway
{
    public function consume(): void;
}
