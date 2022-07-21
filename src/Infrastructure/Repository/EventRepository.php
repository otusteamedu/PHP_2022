<?php

namespace App\Infrastructure\Repository;

use App\Domain\Contract\CacheStorage;
use App\Domain\Contract\EventRepositoryInterface;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Contract\SetEventDTOInterface;
use App\Domain\Model\Event;

class EventRepository implements EventRepositoryInterface
{
    public function __construct(
        private readonly CacheStorage $cache
    ){}


    public function findByParams(GetEventDTOInterface $dto): ?Event
    {
        return $this->cache->find($dto);
    }


    public function set(SetEventDTOInterface $dto): array
    {
        $events = $dto->getEvents();
        $result = [];

        foreach ($events as $eventData)
        {
            $event = new Event($eventData['event'], $eventData['priority'], $eventData['conditions']);

            $this->cache->save($event);

            $result[] = $event;
        }

        return $result;
    }
}
