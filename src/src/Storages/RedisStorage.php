<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Storages;

use Redis;
use RedisException;

class RedisStorage implements StorageInterface
{
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    /**
     * @throws RedisException
     */
    public function add(array $conditions, string $event, int $score): void
    {
        $preparedConditions = $this->conditionsToString($conditions);

        $this->redis->hSet('hEvents', $event, $preparedConditions);

        $this->redis->zAdd('zEvents', $score, $event);
    }

    public function get(array $conditions): string|null
    {
        $preparedConditions = $this->conditionsToString($conditions);


        $hEvents = $this->redis->hGetAll('hEvents');


        foreach ($hEvents as $key => $value) {
            if (str_contains($value, $preparedConditions)) {
                $this->redis->zAdd('zEventsTemp',  0, $key);
            }
        }

        $this->redis->zInterStore('zInterEvents', ['zEvents', 'zEventsTemp']);

        $result = $this->redis->zPopMax('zInterEvents');

        $this->redis->del(['zEventsTemp', 'zInterEvents']);

        return array_key_first($result);
    }

    public function truncate(): void
    {
        $this->redis->del(['hEvents', 'zEvents']);
    }

    private function conditionsToString(array $conditions): string
    {
        $conditions = array_map(fn($key, $item) => "$key:$item", array_keys($conditions), $conditions);

        return implode('::', $conditions);
    }
}