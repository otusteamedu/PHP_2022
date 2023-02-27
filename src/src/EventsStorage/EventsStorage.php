<?php

declare(strict_types=1);

namespace App\EventsStorage;

use App\EventsStorage\Memcached\MemcachedEventsStorage;
use App\EventsStorage\Redis\RedisEventsStorage;
use RedisException;

class EventsStorage implements EventsStorageInterface
{
    private EventsStorageInterface $storage;

    /**
     * @throws RedisException
     */
    public function __construct(array $config)
    {
        $this->storage = match ($config['storage']['provider']) {
            'memcached' => new MemcachedEventsStorage($config['memcached']),
            default => new RedisEventsStorage($config['redis']),
        };
    }

    /**
     * @throws RedisException
     */
    public function testConnection(): string
    {
        return $this->storage->testConnection();
    }

    /**
     * @throws RedisException
     */
    public function addEvent(string $event, string $priority, ...$conditions): bool
    {
        return $this->storage->addEvent($event, $priority, ...$conditions);
    }

    /**
     * @throws RedisException
     */
    public function flushAll(): void
    {
        $this->storage->flushAll();
    }

    /**
     * @throws RedisException
     */
    public function getEvent(...$conditions): string
    {
        return $this->storage->getEvent(...$conditions);
    }
}
