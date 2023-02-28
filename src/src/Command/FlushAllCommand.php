<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class FlushAllCommand extends AbstractCommand
{
    public function __construct(private array $config)
    {
    }

    /**
     * @throws RedisException
     */
    public function execute(): void
    {
        $storage = new EventsStorage($this->config);
        $storage->flushAll();
        $this->message = 'Db flushed';
    }
}
