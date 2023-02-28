<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class GetEventCommand extends AbstractCommand
{
    public function __construct(private array $config, private array $params)
    {
    }

    /**
     * @throws RedisException
     */
    public function execute(): void
    {
        $storage = new EventsStorage($this->config);
        $this->message = $storage->getEvent(...$this->params);
    }
}
