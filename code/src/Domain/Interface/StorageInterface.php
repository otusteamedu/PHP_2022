<?php

namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Domain\Entity\Event;

interface StorageInterface
{
    public function createEvent(Event $event);
    public function deleteAllEvents(string $key): bool;
    public function getEvent(array $conditions);

}