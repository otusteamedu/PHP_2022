<?php

namespace App\Ddd\Application;

use App\Ddd\Domain\Event;

class EventService
{
    private Repository $repository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->repository = $repositoryFactory->create();
    }

    public function addEvent(Event $event): string
    {
        return $this->repository->add($event)
            ? 'Событие добавлено'
            : 'Событие не добавлено';
    }

    public function deleteEvents(): void
    {
        $this->repository->delete();
    }

    public function getEvent(array $request): ?Event
    {
        return $this->repository->get($request);
    }
}
