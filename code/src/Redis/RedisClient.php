<?php

namespace Study\Cinema\Redis;

use Study\Cinema\Model\Event;
use Predis\Client;

class RedisClient implements StorageInterface
{
    protected Client $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => getenv('REDIS_HOST'),
            'port'     => getenv('REDIS_PORT'),
        ]);
    }

    public function createEvent(Event $event) {

        $this->redis->sadd($event::KEY, (array) $event->getId());
        $this->redis->hset($event->getId(), $event::NAME, $event->getName());
        $this->redis->hset($event->getId(), $event::PRIORITY, $event->getPriority());
        $this->redis->hset($event->getId(), $event::CONDITIONS, json_encode($event->getConditions()));

        return true;
    }

    public function deleteAllEvents(string $key): bool
    {
        if (!($events = $this->redis->smembers($key))) {
            return false;
        }
        foreach ($events as $eventID) {
            $this->redis->hdel($eventID, [Event::NAME, Event::PRIORITY, Event::CONDITIONS]);
        }
        $this->redis->srem($key, $events);
        return true;
    }

    public function getEvent(array $searchConditions): array
    {
        $eventData = [];
        if (!($events = $this->redis->smembers(Event::KEY))) {
            return $eventData;
        }

        $suitedEvents = [];
        foreach ($events as $eventID) {
            $conditions = json_decode($this->redis->hget($eventID, Event::CONDITIONS), true, 512, JSON_THROW_ON_ERROR);
            $countSameConditions = 0;

            foreach ($conditions as $parameterKey => $parameterValue) {
                if (!empty($searchConditions[$parameterKey] ) && $searchConditions[$parameterKey] === $parameterValue) {
                    $countSameConditions++;
                }
            }
            if (count($conditions) === $countSameConditions) {
                $suitedEvents[$eventID] = [
                    Event::NAME       => $this->redis->hget($eventID, Event::NAME),
                    Event::PRIORITY   => $this->redis->hget($eventID, Event::PRIORITY),
                    Event::CONDITIONS => $conditions,
                ];
            }
        }
        if ($suitedEvents) {
            usort($suitedEvents, static fn($a, $b) => $a[Event::PRIORITY] < $b[Event::PRIORITY]? 1:-1 );
            $eventData = $suitedEvents[0];

        }
        return $eventData;
    }





}