<?php

namespace App\Service;

use Exception;

class Publisher
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
