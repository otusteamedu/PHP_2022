<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\EventClient;

use Nikolai\Php\Application\Contract\EventClientInterface;
use Nikolai\Php\Application\Dto\CreateEventRequest;
use Nikolai\Php\Application\Dto\CreateEventResponse;
use Nikolai\Php\Application\Dto\FindEventRequest;
use Nikolai\Php\Application\Dto\FindEventResponse;
use Nikolai\Php\Application\Dto\FlushResponse;
use Nikolai\Php\Infrastructure\Exception\EventException;
use Redis;

class RedisEventClient implements EventClientInterface
{
    const EVENTS_PRIORITY_KEY = 'events:priority';

    private Redis $redis;

    public function __construct(string $host, int $port, private int $minEventPriority, private int $maxEventPriority)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    public function create(CreateEventRequest $createEventRequest): CreateEventResponse
    {
        if (!$this->redis->hMSet($createEventRequest->event, $createEventRequest->conditions->toArray())) {
            throw new EventException('Ошибка добавления сообщения: ' . $createEventRequest->event);
        }

        $this->redis->zAdd(self::EVENTS_PRIORITY_KEY, $createEventRequest->priority, $createEventRequest->event);

        return CreateEventResponse::create(
            $createEventRequest->event,
            $createEventRequest->priority,
            $createEventRequest->conditions->toArray()
        );
    }

    private function isEventComplianceConditions(array $eventConditions, array $findConditions): bool
    {
        $result = true;

        foreach ($eventConditions as $key => $value) {
            if (!array_key_exists($key, $findConditions)) {
                $result = false;
                break;
            }

            if ($findConditions[$key] != $value) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public function find(FindEventRequest $findEventRequest): FindEventResponse
    {
        $events = $this->redis->zRevRange(self::EVENTS_PRIORITY_KEY, $this->minEventPriority, $this->maxEventPriority, true);
        foreach ($events as $event => $priority) {
            $eventConditions = $this->redis->hGetAll($event);
            if ($this->isEventComplianceConditions($eventConditions, $findEventRequest->conditions->toArray())) {
                return FindEventResponse::create($event, (int) $priority, $eventConditions);
            }
        }

        $strConditions = '';
        foreach ($findEventRequest->conditions->toArray() as $key => $value) {
            $strConditions .= $key . ' = ' . $value . '; ';
        }

        throw new EventException('Не найдено событие со следующими условиями: ' . $strConditions . PHP_EOL);
    }

    public function flush(): FlushResponse
    {
        $result = $this->redis->flushAll();

        $flushResponse = new FlushResponse();
        if ($result === true) {
            $flushResponse->massage = EventClientInterface::FLUSH_SUCCESS;
        } else {
            $flushResponse->massage = (string) $result;
        }

        return $flushResponse;
    }
}