<?php

declare(strict_types=1);

namespace Otus\App\Model;

use JsonException;
use Otus\App\App;
use Otus\App\Interfaces\StorageInterface;
use Predis\Client;

class Redis implements StorageInterface
{
    protected Client $redis;

    public function __construct()
    {
        $config = App::getConfig();

        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => $config['repository']['redis_host'],
            'port'     => $config['repository']['redis_port'],
            'password' => $config['repository']['redis_pass']
        ]);
    }

    public function saveEvent(Event $event): bool
    {
        $this->redis->sadd($event::KEY, (array) $event->getId());
        $this->redis->hset($event->getId(), $event::NAME, $event->getName());
        $this->redis->hset($event->getId(), $event::PRIORITY, $event->getPriority());
        $this->redis->hset($event->getId(), $event::CONDITIONS, $event->getConditions());

        return true;
    }

    public function getEvent(array $params): array
    {
        $event = [];
        if (!($events = $this->redis->smembers(Event::KEY))) {
            return $event;
        }

        $relatedEvents = [];
        foreach ($events as $eventID) {
            $conditions = json_decode(
                $this->redis->hget($eventID, Event::CONDITIONS),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $countSameConditions = 0;
            foreach ($conditions as $parameterKey => $parameterValue) {
                if ($params[$parameterKey] === $parameterValue) {
                    $countSameConditions++;
                }
            }

            if (count($conditions) === $countSameConditions) {
                $relatedEvents[$eventID] = [
                    Event::NAME       => $this->redis->hget($eventID, Event::NAME),
                    Event::PRIORITY   => $this->redis->hget($eventID, Event::PRIORITY),
                    Event::CONDITIONS => $this->redis->hget($eventID, Event::CONDITIONS),
                ];
            }
        }

        if ($relatedEvents) {
            usort($relatedEvents, static fn($first, $second) => $second[Event::PRIORITY] <=> $first[Event::PRIORITY]);
            // использовать <=> иначе будет Deprecated: usort в php 8.1
            // сначала $second потом $first - порядок - от большего PRIORITY к меньшему PRIORITY
            $event = reset($relatedEvents);
        }

        return $event;

    }

    public function deleteEvents(string $key): bool
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


}
