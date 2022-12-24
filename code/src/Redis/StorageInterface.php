<?php

namespace Study\Cinema\Redis;

use Study\Cinema\Model\Event;

interface StorageInterface
{
    public function createEvent(Event $event);
    public function deleteAllEvents(string $key): bool;
    public function getEvent(array $conditions);

}