<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Entity\Event;
use Redis;

class RedisStorage implements StorageInterface
{
    private Redis $redis;

    public function __construct(array $options)
    {
        $this->redis = new Redis();
        $this->redis->connect($options['host']);
    }

    public function save(Event $event): void
    {
        $this->redis->zAdd('events', $event->getPriority(), $event->getEventName());

        $conditions = $event->getConditions()->toArray();

        $json_conditions = [];

        array_walk($conditions, static function ($condition, $key) use (&$json_conditions) {
            $json_conditions[] = json_encode([$key => $condition]);
        });

        $this->redis->sAdd('event:'.$event->getEventName().':conditions', ...$json_conditions);
    }

    public function find(array $params): false|Event
    {
        $allEventNames = $this->redis->zRevRange('events', 0, -1, true);

//        foreach ($allEventNames as $eventName) {
//
//        }

    }

    public function clear(): void
    {
        $this->redis->flushDB();
    }
}