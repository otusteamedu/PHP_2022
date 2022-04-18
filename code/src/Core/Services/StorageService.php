<?php

namespace Decole\Hw13\Core\Services;

use Cassandra\Map;
use Decole\Hw13\Core\Dtos\EventAddDto;
use Decole\Hw13\Core\Kernel;
use Decole\Hw13\Core\Repositories\StorageRepositoryInterface;
use Decole\Hw13\Core\Repositories\RedisStorageRepository;

final class StorageService
{
    private StorageRepositoryInterface $repository;

    public function __construct()
    {
        $storage = Kernel::getConfigParam('STORAGE');
        $class = 'Decole\Hw13\Core\Repositories\\' . ucfirst($storage) . 'StorageRepository';
        $this->repository = new $class();
    }

    public function save(EventAddDto $dto): void
    {
        $this->repository->save($dto);
    }
}