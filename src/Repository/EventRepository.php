<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository;

use Dkozlov\Otus\Application;
use Dkozlov\Otus\Domain\Event;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\EventNotFoundException;
use Dkozlov\Otus\Repository\Dto\AddEventRequest;
use Dkozlov\Otus\Repository\Dto\GetEventRequest;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;
use Redis;
use RedisException;

class EventRepository implements EventRepositoryInterface
{
    private const EVENT_LIST = 'event:list';

    private const EVENT_RATING = 'event:rating';

    private const EVENT_TEMP = 'event:temp';

    private const EVENT_INTER_STORE = 'event:inter-store';

    private Redis $redis;

    /**
     * @throws ConnectionTimeoutException
     */
    public function __construct()
    {
        $this->redis = new Redis();

        try {
            $this->redis->connect(
                Application::config('REDIS_HOST'),
                (int) Application::config('REDIS_PORT')
            );
        } catch (RedisException) {
            throw new ConnectionTimeoutException('Failed to connect to the server');
        }
    }

    /**
     * @throws ConnectionTimeoutException
     */
    public function addEvent(AddEventRequest $request): void
    {
        try {
            $name = $request->getName();
            $conditions = $this->conditionsToString($request->getConditions());

            $this->redis->zAdd(self::EVENT_RATING, $request->getPriority(), $name);
            $this->redis->hSet(self::EVENT_LIST, $name, $conditions);
        } catch (RedisException) {
            throw new ConnectionTimeoutException('Failed to connect to the server');
        }
    }

    /**
     * @throws ConnectionTimeoutException
     */
    public function clearEvents(): void
    {
        try {
            $this->redis->del(self::EVENT_LIST, self::EVENT_RATING);
        } catch (RedisException) {
            throw new ConnectionTimeoutException('Failed to connect to the server');
        }
    }

    /**
     * @throws ConnectionTimeoutException
     * @throws EventNotFoundException
     */
    public function getEvent(GetEventRequest $request): Event
    {
        try {
            $events = $this->getEventsByParams($request->getParams());

            if (empty($events)) {
                $params = serialize($request->getParams());

                throw new EventNotFoundException("Event with params \"{$params}\" not found");
            }

            $event = array_key_first($events);

            return new Event($event);
        } catch (RedisException) {
            throw new ConnectionTimeoutException('Failed to connect to the server');
        }
    }

    /**
     * @throws RedisException
     */
    private function getEventsByParams(array $params): array
    {
        $conditions = $this->conditionsToString($params);
        $events = $this->redis->hGetAll(self::EVENT_LIST);

        foreach ($events as $key => $eventConditions) {
            if ($conditions === $eventConditions) {
                $this->redis->zAdd(self::EVENT_TEMP, 0, $key);
            }
        }

        $this->redis->zInterStore(self::EVENT_INTER_STORE, [self::EVENT_RATING, self::EVENT_TEMP]);

        $event = $this->redis->zPopMax(self::EVENT_INTER_STORE);

        $this->redis->del(self::EVENT_INTER_STORE, self::EVENT_TEMP);

        return $event;
    }

    private function conditionsToString(array $conditions): string
    {
        ksort($conditions);

        $conditions = array_map(static fn ($key, $value) => "$key:$value", array_keys($conditions), $conditions);

        return implode('::', $conditions);
    }
}