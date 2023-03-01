<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Redis\Query;

use Kogarkov\Es\Model\EventModel;
use Predis as PR;

class Event
{
    private PR\Client $client;
    private $key = 'event';

    public function __construct(object $client)
    {
        $this->client = $client;
    }

    public function getOne(array $conditions): array
    {       
        $storage_results = $this->client->zrevrangebyscore(
            $this->key,
            '+inf',
            '-inf',
            ['withscores' => true]
        );

        $result = [];

        foreach ($storage_results as $event => $score) {
            $event_data = json_decode($event, true);

            foreach (explode(',', $event_data['conditions']) as $condition) {
                $param = explode('=', $condition);
                if ($conditions[$param[0]] != $param[1]) {
                    continue 2;
                }
            }
            
            $result = $event_data;
            break;
        }

        return $result;
    }

    
    public function getAll(): array
    {       
        $storage_results = $this->client->zrange($this->key, 0, -1);

        $result = [];

        foreach ($storage_results as $event) {
            $result[] = json_decode($event, true);
        }

        return $result;
    }

    public function add(EventModel $event): int
    {
        return $this->client->zadd(
            $this->key,
            [
                $event->getEvent() => $event->getPriority()
            ]
        );
    }

    public function deleteAll(): int
    {
        return $this->client->del($this->key);
    }
}
