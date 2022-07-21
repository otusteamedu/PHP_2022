<?php

namespace App\Infrastructure\Storage;

use App\Domain\Contract\CacheStorage;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Model\Event;
use \Redis;

class RedisStorage implements CacheStorage
{
    private const CURRENT = 'current';
    private const EVENT = 'event';
    private const EVENTS = 'events';
    private Redis $redis;


    public function __construct()
    {
        // здесь должен прокидываться кеш из фреймворка
        // но в рамках обучения не стал его использовать
        $this->redis = new \Redis();

        if (!$this->redis->connect('redis', 6379)) {
            throw new \Exception('Redis is not available');
        }
    }


    public function find(GetEventDTOInterface $dto): ?Event
    {
        $tag = self::EVENT . ':' . self::CURRENT;
        $this->redis->sRem($tag);
        $this->redis->sAdd($tag, ...$this->toJson($dto->getParams()));

        $events = $this->redis->zRevRange(self::EVENTS, 0, -1, true);

        foreach ($events as $eventName => $range) {
            $diff = $this->redis->sDiff($tag, self::EVENT .':' . $eventName);

            if (empty($diff)) {
                $event = $this->makeEvent($eventName);

                if ($event) {
                    return $event;
                }
            }
        }

        return null;
    }


    public function save(Event $event): void
    {
        $this->redis->zAdd(self::EVENTS, $event->getPriority(), $event->getEvent());
        $this->redis->sAdd(self::EVENT . ':' . $event->getEvent(), ...$this->toJson($event->getConditions()));
    }


    public function clear(): void
    {
        $this->redis->flushDB();
    }


    private function makeEvent(string $eventName): ?Event
    {
        $data = $this->redis->sMembers(self::EVENT . ':' . $eventName);
        $priority = $this->redis->zScore(self::EVENTS, $eventName);

        if ($data) {
//            $this->redis->zRem(self::EVENTS, $eventName);
//            $this->redis->sRem(self::EVENT . ':' . $eventName);

            return new Event($eventName, $priority, $this->toArray($data));
        }

        return null;
    }


    private function toJson(array $data): array
    {
        $result = [];

        foreach ($data as $param => $value)
        {
            $result[] = json_encode($param . '=' . $value, JSON_THROW_ON_ERROR);
        }

        return $result;
    }

    private function toArray(array $data): array
    {
        $result = [];

        foreach ($data as $value)
        {
            $decoded = json_decode($value, JSON_THROW_ON_ERROR);
            [$paramName, $paramValue] = explode('=', $decoded);

            $result[$paramName] = $paramValue;
        }

        return $result;
    }
}
