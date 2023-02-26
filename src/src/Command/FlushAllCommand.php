<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class FlushAllCommand implements CommandInterface
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
        echo 'Db flushed' . PHP_EOL;
    }
}