<?php

declare(strict_types=1);

namespace Octopus\App\Storage;

use Octopus\App\Storage\Interfaces\StorageInterface;
use Redis;

class RedisStorage implements StorageInterface
{
    private Redis $redis;

    private const HOST = 'redis';

    public function __construct()
    {
        try {
            $this->redis = new Redis();
            $this->redis->connect(self::HOST);
        } catch (\RedisException $e) {
        }
    }

    public function add(array $params): void
    {
        $event = $params['event'] ?? null;
        $priority = $params['priority'] ?? null;
        $conditions = $params['conditions'] ?? null;
        $preparedConditions = $this->conditionsToString($conditions);

        $this->redis->hSet('hEvents', $event, $preparedConditions);
        $this->redis->zAdd('zEvents', $priority, $event);
    }

    public function get(array $params): string|null
    {
        $conditions = $params['conditions'] ?? null;
        $preparedConditions = $this->conditionsToString($conditions);
        $hEvents = $this->redis->hGetAll('hEvents');

        foreach ($hEvents as $key => $value) {
            if (str_contains($value, $preparedConditions)) {
                $this->redis->zAdd('zEventsTemp', 0, $key);
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
