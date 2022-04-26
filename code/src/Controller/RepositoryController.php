<?php

namespace KonstantinDmitrienko\App\Controller;

use JsonException;
use KonstantinDmitrienko\App\Model\Repository;

/**
 * RepositoryController
 */
class RepositoryController
{
    /**
     * @var Repository
     */
    protected Repository $repository;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->repository = new Repository();
    }

    /**
     * @throws JsonException
     */
    public function saveEvent($event): bool
    {
        return $this->repository->saveEvent($event);
    }

    /**
     * @return bool
     */
    public function deleteEvents(): bool
    {
        return $this->repository->deleteEvents();
    }

    /**
     * @throws JsonException
     */
    public function getEvent($params): array
    {
        return $this->repository->getEvent($params);
    }
}
