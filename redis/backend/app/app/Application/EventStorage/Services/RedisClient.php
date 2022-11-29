<?php

namespace App\Application\EventStorage\Services;

use App\Application\EventStorage\Contracts\EventStorageInterface;
use Predis\Client;

class RedisClient
    implements EventStorageInterface
{
    private const NAMESPACE = 'events';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client(config('database.redis.default.url'));
    }

    public function add(string $eventName, int $priority, array $params): void
    {
        ksort($params, SORT_NATURAL);
        $key = fn() => sprintf('%s:%s:%s:%s', self::NAMESPACE, bin2hex(json_encode($params)), $eventName, $priority);
        $this->client->set($key(), '-');
    }

    public function clearAll(): void
    {
        $this->client->del($this->client->keys(sprintf('%s:*', self::NAMESPACE)));
    }

    public function findEvent(array $params): ?string
    {
        ksort($params, SORT_NATURAL);
        $pattern = fn() => sprintf('%s:%s:*', self::NAMESPACE, bin2hex(json_encode($params)));

        $events = [];
        foreach ($this->client->keys($pattern()) as $key) {
            [2 => $eventName, 3 => $priority] = explode(':', $key);
            $events[intval($priority)][] = $eventName;
        };

        ksort($events);

        $eventNames = [];
        foreach ($events as $en) {
            $eventNames = $en;
            break;
        }

        natcasesort($eventNames);

        dd(array_values($eventNames)[0] ?? null);
    }
}
