<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class TestCommand extends AbstractCommand
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
        $this->message = $storage->testConnection();
    }
}
