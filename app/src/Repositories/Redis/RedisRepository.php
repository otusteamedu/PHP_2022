<?php

declare(strict_types=1);

namespace App\Src\Repositories\Redis;

use Redis;
use App\Src\Event\Event;
use App\Src\Repositories\Contracts\Repository;

final class RedisRepository implements Repository
{
    private Redis $redis;

    /**
     * class construct
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect(host: $_ENV['REDIS_HOST'], port: (int)$_ENV['REDIS_PORT']);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function insert(Event $event): void
    {
        $this->redis->zAdd(
            $event->getKey(),
            $event->getScore(),
            $event->getEventData()
        );
    }

    /**
     * @param Event $event
     * @return array
     */
    public function getAllEvents(Event $event): array
    {
        /*
         * именнованные параметры на PHP8.1 полностью не поддерживаются - в частности не поддерживается параметр
         * withscores
         */
        return $this->redis->zRange($event->getKey(), 0, -1);
    }

    /**
     * @param Event $event
     * @return array
     */
    public function getConcreteEvent(Event $event): array
    {
        /*
         * есть методы zRangeByScore и zRevRangeByScore - помимо названия, нужно еще менять параметры start и end;
         * для zRangeByScore - start='-inf', end='+inf'; для zRevRangeByScore - наоборот
         */
        $sorted_results = $this->redis->zRevRangeByScore(
            key: $event->getKey(),
            start: '+inf',
            end: '-inf',
            options: ['withscores' => true]
        );

        $result = [];

        foreach ($sorted_results as $event_data => $score) {
            $event_data_to_array = json_decode(json: $event_data, associative: true);
            $event_conditions = json_decode(json: $event->getConditions(), associative: true);

            /*
             * учитывая, что возвращаемый массив из редиса отсортирован по score, начиная с максимального, то, если
             * if срабатывает, значит самым первым будет событие с максимальным score
             */
            if ($event_data_to_array['conditions'] === $event_conditions['conditions']) {
                $result[$event_data] = $score;
                break;
            }
        }

        return $result;
    }

    /**
     * @return void
     */
    public function deleteAll(): void
    {
        $this->redis->flushAll();
    }

    /**
     * @param Event $event
     * @return void
     */
    public function deleteConcreteEvent(Event $event): void
    {
        $this->redis->zRem($event->getKey(), $event->getEventData());
    }
}
