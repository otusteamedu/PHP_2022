<?php

namespace App\EventsStorage\Redis;

use App\EventsStorage\EventsStorageInterface;
use Exception;
use Redis;
use RedisException;

class RedisEventsStorage implements EventsStorageInterface
{
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct(array $config)
    {
        $this->redis = new Redis();
        $this->redis->connect($config['host'], $config['port']);
    }

    /**
     * @throws RedisException
     */
    public function testConnection(): string
    {
        return $this->redis->ping() ? 'Success connected to Redis' : 'Failed to connect to Redis';
    }

    /**
     * @throws RedisException
     */
    public function addEvent(string $event, string $priority, ...$conditions): bool
    {
        $result = $this->redis->sAdd($event, ...$conditions);
        foreach ($conditions as $condition) {
            $result = $this->redis->zAdd($condition, [], $priority, $event);
        }
        return (bool)$result;
    }

    /**
     * @throws RedisException
     */
    public function flushAll(): void
    {
        $this->redis->flushAll();
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function getEvent(...$conditions): string
    {
        $queryName = 'Query:' . bin2hex(random_bytes(10));
        $event = '';
        $this->redis->sAdd($queryName, ...$conditions);

        foreach ($conditions as $condition) {
            $result = $this->redis->zPopMax($condition, 1);
            if (!empty($result)) {
                $event = key($result);
            }
            if (!empty($result) && $event !== '') {
                $this->redis->zAdd($condition, [], $result[$event], $event);
            }
            if ($event !== '' && empty($this->redis->sDiff($event, $queryName))) {
                break;
            }
        }
        $this->redis->del($queryName);
        return $event;
    }
}