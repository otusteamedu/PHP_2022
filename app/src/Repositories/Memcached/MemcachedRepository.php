<?php

declare(strict_types=1);

namespace App\Src\Repositories\Memcached;

use Memcached;
use App\Src\Event\Event;
use App\Src\Repositories\Contracts\Repository;

final class MemcachedRepository implements Repository
{
    private Memcached $memcached;

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer(host: $_ENV['MEMCACHED_HOST'], port: (int)$_ENV['MEMCACHED_PORT']);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function insert(Event $event): void
    {
        $key = $event->getKey();

        $already_added_data = $this->memcached->get(key: $key) ?: [];

        $new_data = array_merge(
            $already_added_data,
            [json_decode(json: $event->getEventDataForMemcached(), associative: true)]
        );

        $result = $this->memcached->replace(key: $key, value: $new_data);

        if (!$result) {
            $this->memcached->set(key: $key, value: $new_data);
        }
    }

    /**
     * @param Event $event
     * @return array
     */
    public function getAllEvents(Event $event): array
    {
        return $this->memcached->get(key: $event->getKey()) ?: [];
    }

    /**
     * @param Event $event
     * @return array
     */
    public function getConcreteEvent(Event $event): array
    {
        $events = $this->memcached->get(key: $event->getKey()) ?: [];

        uasort(array: $events, callback: function ($first, $second) {
            // сначала $second потом $first - порядок - от большего score к меньшему score
            return $second['score'] <=> $first['score'];
        });

        $conditions = json_decode(json: $event->getConditions(), associative: true);

        /*
         * uasort() сохраняет нумерацию ключей как и array_filter(), поэтому к array_filter() применяем array_value()
         * чтобы нужное нам событие с максимальным значением score находилось под нулевым индексом
         */
        $result = array_values(
            array: array_filter(
                array: $events,
                callback: fn($event) => $event['conditions'] === $conditions['conditions']
            )
        );

        return $result[0];
    }

    /**
     * @return void
     */
    public function deleteAll(): void
    {
        $this->memcached->flush();
    }

    /**
     * @param Event $event
     * @return void
     */
    public function deleteConcreteEvent(Event $event): void
    {
        $events = $this->memcached->get(key: $event->getKey()) ?: [];

        $desired_event = json_decode(json: $event->getEventData(), associative: true);

        $new_events = array_values(
            array: array_filter(
                array: $events,
                callback: fn($event) => !(
                    ($event['conditions'] === $desired_event['conditions'])
                    && ($event['event'] === $desired_event['event'])
                )
            )
        );

        $result = $this->memcached->replace(key: $event->getKey(), value: $new_events);

        if (!$result) {
            $this->memcached->set(key: $event->getKey(), value: $new_events);
        }
    }
}
