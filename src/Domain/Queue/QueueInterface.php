<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Queue;

use Exception;

interface QueueInterface
{
    /**
     * @throws Exception
     */
    public function publishWithResponse(MessageInterface $message): string;

    /**
     * @throws Exception
     */
    public function publish(MessageInterface $message): void;

    /**
     * @throws Exception
     */
    public function receive(): void;
}