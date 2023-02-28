<?php

namespace App\Service;

use App\RabbitMQ\Channel;
use App\RabbitMQ\Message;
use Exception;

class UserPublisher
{
    public function __construct(
        private Channel $channel
    ) {
    }

    /**
     * @throws Exception
     */
    public function write(string $message, string $queue): void
    {
        $this->channel
            ->connect()
            ->open($queue)
            ->publish(Message::create($message), $queue)
            ->close();
    }
}
