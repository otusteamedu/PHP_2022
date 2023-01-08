<?php

declare(strict_types=1);

namespace App\App\Event;

use Predis\Client;

/**
 * Redis хранилище для событий
 */
class RedisEventStorage implements EventStorageInterface
{
    private const EVENTS_ZSET_NAME = 'event';
    private const EVENTS_CONDITIONS_SET_PREFIX = 'event:condition:';
    private const EVENTS_CONDITIONS_HSET_PREFIX = 'event:';
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @inheritDoc
     */
    public function add(Event $event): void
    {
        // Добавляем событие в ZSET, чтобы удобно работать с весами (приоритетами)
        $this->client->zadd(self::EVENTS_ZSET_NAME, [$event->event => $event->priority]);

        $this->client->del(self::EVENTS_CONDITIONS_HSET_PREFIX . $event->event);
        foreach ($event->conditions as $conditionName => $conditionValue) {
            $this->client->hset(self::EVENTS_CONDITIONS_HSET_PREFIX . $event->event, $conditionName, $conditionValue);
            $this->client->sadd(self::EVENTS_CONDITIONS_SET_PREFIX . $conditionName . ':' . $conditionValue, [$event->event]);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteAll(): void
    {
        $this->client->flushdb();
    }

    /**
     * @inheritDoc
     */
    public function findByConditions(array $conditions): array
    {
        // Получаем все события, которые подходят хотя бы под одно из условий
        $eventNames = $this->getEventsForAnyConditions($conditions);

        // Проверяем, полные условия, прописанные для событий, и проверяем, подходят ли они под текущие
        $eventNames = $this->filterEventsByFullConditions($eventNames, $conditions);

        // Генерируем объекты событий по названиям и возвращаем
        return \array_map([$this, 'generateEvent'], $eventNames);
    }


    public function findMostAppropriateEventByCondition(array $conditions): ?Event
    {
        $events = $this->findByConditions($conditions);

        $queue = new \SplPriorityQueue();
        foreach ($events as $event) {
            $queue->insert($event, $event->priority);
        }
        return $queue->top();
    }


    /**
     * Возвращает список событий, которые подходят хотя бы под одно из условий
     */
    private function getEventsForAnyConditions(array $conditions): array
    {
        $unionConditions = [];
        foreach ($conditions as $conditionName => $conditionValue) {
            $unionConditions[] = self::EVENTS_CONDITIONS_SET_PREFIX . $conditionName . ':' . $conditionValue;
        }
        return $this->client->sunion($unionConditions);
    }

    /**
     * Проверяет, соответствует ли условия событий переданным. Возвращает отфильтрованный список тех событий, которые
     * удовлетворяют переданным
     *
     * @return string[]
     */
    private function filterEventsByFullConditions(array $eventNames, array $conditions): array
    {
        $filteredEvents = [];
        foreach ($eventNames as $eventName) {
            $eventConditions = $this->client->hgetall(self::EVENTS_CONDITIONS_HSET_PREFIX . $eventName);
            $isSuitableEvent = true;
            foreach ($eventConditions as $eventConditionName => $eventConditionValue) {
                if (!isset($conditions[$eventConditionName]) || $conditions[$eventConditionName] !== $eventConditionValue) {
                    $isSuitableEvent = false;
                    break;
                }
            }

            if ($isSuitableEvent) {
                $filteredEvents[] = $eventName;
            }
        }

        return $filteredEvents;
    }

    private function generateEvent(mixed $eventName): Event
    {
        $eventConditions = $this->client->hgetall(self::EVENTS_CONDITIONS_HSET_PREFIX . $eventName);
        $eventScore = (int) $this->client->zscore(self::EVENTS_ZSET_NAME, $eventName);

        return new Event($eventScore, $eventName, $eventConditions);
    }
}