<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Entity\Event;
use Redis;

class RedisStorage implements StorageInterface
{
    public static string $events = 'events';
    public static string $event = 'event';
    public static string $conditions = 'conditions';
    public static string $requested_params = 'user:last_request:params';

    private Redis $redis;

    public function __construct(array $options)
    {
        $this->redis = new Redis();
        $this->redis->connect($options['host']);
    }

    public function save(Event $event): void
    {
        $this->redis->zAdd(self::$events, $event->getPriority(), $event->getEventName());

        $conditions = $event->getConditions()->toArray();
        $json_conditions = $this->packConditionsToJson($conditions);
        $this->redis->sAdd(self::$event.':'.$event->getEventName().':'.self::$conditions, ...$json_conditions);
    }

    public function find(array $params): false|Event
    {
        $json_conditions = $this->packConditionsToJson($params);
        $this->redis->sAdd(self::$requested_params, ...$json_conditions);

        $allEventNames = $this->redis->zRevRange(self::$events, 0, -1, true);

        foreach ($allEventNames as $eventName => $range) {

            $diff = $this->redis->sDiff(self::$requested_params, self::$event.':'.$eventName.':'.self::$conditions);

            if (empty($diff)) {

                $event = $this->restoreEvent($eventName);

                if ($event !== false) {
                    return $event;
                }
            }
        }

        return false;
    }

    public function clear(): void
    {
        $this->redis->flushDB();
    }

    private function restoreEvent(string $eventName): false|Event
    {
        $priority = $this->redis->zScore(self::$events, $eventName);
        $json_conditions = $this->redis->sMembers(self::$event.':'.$eventName.':'.self::$conditions);

        if ($priority !== false && is_array($json_conditions) && !empty($json_conditions)) {

            $event = new Event();

            $event->setEventName($eventName);
            $event->setPriority((int)$priority);

            $conditions = $this->unpackConditionsFromJson($json_conditions);

            foreach ($conditions as $condition) {
                foreach ($condition as $paramKey => $paramValue) {
                    $event->addCondition($paramKey, $paramValue);
                }
            }

            return $event;
        }

        return false;
    }

    private function packConditionsToJson(array $conditions): array
    {
        $json_conditions = [];

        array_walk($conditions, static function ($condition, $key) use (&$json_conditions) {
            $json_conditions[] = json_encode([$key => $condition]);
        });

        return $json_conditions;
    }

    private function unpackConditionsFromJson(array $json_conditions): array
    {
        $conditions = [];

        array_walk($json_conditions, static function ($json_condition) use (&$conditions) {
            $conditions[] = json_decode($json_condition, true);
        });

        return $conditions;
    }
}