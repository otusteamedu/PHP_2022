<?php

namespace App\Service\EventService\Repository;

use Redis;
use App\Entity\Event;

class RedisEventRepository implements EventRepositoryInterface
{
    private Redis $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = new Redis;
        $this->redis->connect($host, $port);
    }

    public function get(): array
    {
        $events = [];
        $eventKeys = $this->redis->keys('event:*');
        if (count($eventKeys) === 0) {
            return [];
        }
        foreach ($eventKeys as $eventKey) {
            $eventData = $this->redis->hGetAll($eventKey);
            $events[] = $this->createAndFillEvent($eventData);
        }
        usort($events, fn($a, $b) => $b <=> $a);
        return $events;
    }

    public function findByParams(array $inputParams): ?Event
    {
        $params = [];
        foreach ($inputParams as $name => $value) {
            $params[] = "event_param:$name:$value";
        }
        $events = [];
        $eventIds = $this->redis->sInter(...$params);
        foreach ($eventIds as $eventId) {
            $events[] = $this->redis->hGetAll("event:$eventId");
        }
        usort($events, fn($a, $b) => $b['priority'] <=> $a['priority']);
        return empty($eventIds) ? null : $this->createAndFillEvent($events[0]);
    }

    public function add(Event $event): Event
    {
        $id = $this->redis->incr('event_last_id');
        $priority = $event->getPriority();
        $this->redis->hMSet("event:$id", [
            'id' => $id,
            'priority' => $priority,
            'name' => $event->getName(),
            'params' => json_encode($event->getConditions(), true)
        ]);
        foreach ($event->getConditions() as $condition) {
            $key = sprintf(
                "event_param:%s:%s",
                trim($condition['name']),
                trim($condition['value']),
            );
            $this->redis->sAdd($key, $id);
        }
        return $event;
    }

    public function findById(int $id): ?Event
    {
        $eventData = $this->redis->hGetAll("event:$id");
        if (empty($eventData)) {
            return null;
        }
        return $this->createAndFillEvent($eventData);
    }

    public function remove(Event $event): void
    {
        $id = $event->getId();
        $params = $this->redis->keys('event_param:*');
        foreach ($params as $param) {
            $this->redis->sRem($param, $id);
            if ($this->redis->sCard($param) < 1) {
                $this->redis->del($param);
            }
        }
        $this->redis->del("event:$id");
    }

    private function createAndFillEvent(array $eventData): Event
    {
        $event = new Event();
        $event->setId($eventData['id']);
        $event->setName($eventData['name']);
        $event->setPriority($eventData['priority']);
        $event->setConditions(json_decode($eventData['params'], true));
        return $event;
    }
}
