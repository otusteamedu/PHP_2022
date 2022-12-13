<?php

declare(strict_types=1);

namespace Otus\App\Controller;

use JsonException;
use Otus\App\Model\Repository;

class RepositoryController
{
    protected Repository $repository;

    public function __construct()
    {
        $this->repository = new Repository();
    }

    public function saveEvent($event): bool
    {
        return $this->repository->saveEvent($event);
    }

    public function deleteEvents(): bool
    {
        return $this->repository->deleteEvents();
    }

    public function getEvent($params): array
    {
        return $this->repository->getEvent($params);
    }
}
