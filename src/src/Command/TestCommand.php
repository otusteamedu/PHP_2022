<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class TestCommand implements CommandInterface
{
    /**
     * @param array $config
     */
    public function __construct(private array $config)
    {
    }

    /**
     * @throws RedisException
     */
    public function execute(): void
    {
        $storage = new EventsStorage($this->config);
        echo $storage->testConnection() . PHP_EOL;
    }
}
