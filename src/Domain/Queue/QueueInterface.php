<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Queue;

use Closure;
use DKozlov\Otus\Domain\Sender\SenderInterface;
use DKozlov\Otus\Infrastructure\Queue\DTO\MessageInterface;

interface QueueInterface
{
    public function publish(MessageInterface $message): void;

    public function receive(): void;
}