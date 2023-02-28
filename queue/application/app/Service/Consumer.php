<?php

namespace App\Service;

class Consumer
{
    public function __construct(
        private Channel $channel
    ) {
    }

    public function read(string $queue): void
    {
        $this->channel
            ->connect()
            ->open($queue)
            ->consume($queue)
            ->read();
    }
}
