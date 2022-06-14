<?php

namespace App\Service\EventService;

use App\Entity\Event;
use App\Service\EventService\Repository\EventRepositoryInterface;

class EventService
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository
    )
    {
    }

    public function add(Event $event): void
    {
        $this->eventRepository->add($event);
    }

    public function remove(Event $event): void
    {
        $this->eventRepository->remove($event);
    }

    public function findByParams(array $params): ?Event
    {
        return $this->eventRepository->findByParams($params);
    }

    public function findById(int $id): ?Event
    {
        return $this->eventRepository->findById($id);
    }

    public function get(): array
    {
        return $this->eventRepository->get();
    }
}