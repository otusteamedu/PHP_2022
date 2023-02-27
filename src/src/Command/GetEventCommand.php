<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class GetEventCommand implements CommandInterface
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
        echo $storage->getEvent(...$this->params) . PHP_EOL;
    }
}
