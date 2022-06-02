<?php


namespace Decole\Hw18\Domain\Service;


use Decole\Hw18\Domain\Repository\BaseProductRepository;

class BaseProductListService
{
    public function __construct(private BaseProductRepository $repository)
    {
    }

    public function list(): array
    {
        return $this->repository->getAll();
    }
}