<?php


namespace Decole\Hw13\Core\Services;


use Decole\Hw13\Core\Dtos\EventAddDto;
use Decole\Hw13\Core\Dtos\EventFindDto;
use Decole\Hw13\Core\Kernel;
use Decole\Hw13\Core\Repositories\StorageRepositoryInterface;
use Klein\Response;

final class StorageService
{
    private StorageRepositoryInterface $repository;

    public function __construct()
    {
        try {
            $storage = Kernel::getConfigParam('STORAGE');
            $class = 'Decole\Hw13\Core\Repositories\\' . ucfirst($storage) . 'StorageRepository';
            $this->repository = new $class();
        } catch (\Throwable $e) {
            (new Response())->json(['system error' => $e->getMessage()]);
        }
    }

    public function save(EventAddDto $dto): void
    {
        $this->repository->save($dto);
    }

    public function find(EventFindDto $dto): array
    {
        return $this->repository->getByParams($dto->params);
    }

    public function flush(): void
    {
        $this->repository->deleteAll();
    }
}