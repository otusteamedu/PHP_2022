<?php

declare(strict_types=1);

namespace App\Command;

use App\EventsStorage\EventsStorage;
use RedisException;

class AddEventCommand implements CommandInterface
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
        $message = $storage->addEvent(...$this->params) ? 'Success' : 'Failed';
        echo $message . PHP_EOL;
    }
}
