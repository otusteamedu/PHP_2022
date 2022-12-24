<?php

namespace Study\Cinema\Repository;
use Study\Cinema\Redis\StorageInterface;
use Study\Cinema\Model\Event;

class EventRepository
{

    private $storage;
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
    public function create(Event $event): bool
    {
        $this->storage->createEvent($event);
        return true;
    }

    public function find(array $conditions): ?Event
    {
        $eventData = $this->storage->getEvent($conditions);
        if(empty($eventData))
            return null;
        $event = new Event();
        $event->setName($eventData['name']);
        $event->setPriority($eventData['priority']);
        $event->setConditions($eventData['conditions']);

        return $event;
    }

    public function delete(): bool
    {
        return $this->storage->deleteAllEvents(Event::KEY);
    }

}