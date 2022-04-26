<?php

namespace KonstantinDmitrienko\App\Interfaces;

use KonstantinDmitrienko\App\Model\Event;

/**
 * StorageInterface
 */
interface StorageInterface
{
    /**
     * @param Event $event
     *
     * @return bool
     */
    public function saveEvent(Event $event): bool;

    /**
     * @param string $key
     *
     * @return bool
     */
    public function deleteEvents(string $key): bool;

    /**
     * @param array $params
     *
     * @return array
     */
    public function getEvent(array $params): array;
}
