<?php

namespace Redis\App\Service;

use Redis\App\Model\Event;
use Redis\App\Repository\Factory\RepositoryFactory;
use Redis\App\Repository\Repository;

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
