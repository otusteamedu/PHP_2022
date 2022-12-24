<?php

namespace Study\Cinema\Controller;

use Study\Cinema\DTO\EventCreateDTO;
use Study\Cinema\Exception\EventExeption;
use Study\Cinema\Model\Event;
use Study\Cinema\Redis\RedisClient;
use Study\Cinema\Repository\EventRepository;


class EventController
{

    private EventRepository $eventRepository;
    public function __construct(EventRepository $eventRepository){
        $this->eventRepository = $eventRepository;
    }

    public function create(EventCreateDTO $createDTO): bool
    {
        $event = new Event();
        $event->setId(uniqid(Event::KEY));
        $event->setName($event->getId());
        $event->setPriority($createDTO->priority);
        $event->setConditions($createDTO->conditions);

        if(!$this->eventRepository->create($event)){
            return false;
        }
        return true;

    }

    public function get(array $conditions): ?Event
    {
        $event = $this->eventRepository->find($conditions);

        return $event;
    }

    public function delete(): bool
    {
        if($this->eventRepository->delete())
        {
            return true;
        }
        return false;
    }
}