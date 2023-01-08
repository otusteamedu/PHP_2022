<?php

namespace App\App\Event;

/**
 * Интерфейс для системы хранения событий
 */
interface EventStorageInterface
{
    /**
     * Добавить событие в систему
     */
    public function add(Event $event): void;

    /**
     * Очищает все доступные события
     */
    public function deleteAll(): void;

    /**
     * Возвращает список событий из хранилища, которые соответствуют переданным критериям.
     *
     * @return Event[] Список событий в порядке уменьшения важности (priority)
     */
    public function findByConditions(array $conditions): array;

    /**
     * Возвращает наиболее подходящее событие для переданных условий
     */
    public function findMostAppropriateEventByCondition(array $conditions): ?Event;
}