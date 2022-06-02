<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service;


use Decole\Hw18\Domain\Repository\InnerProductRepository;

class InnerProductService
{
    public function __construct(private InnerProductRepository $repository)
    {
    }

    public function list(): array
    {
        return $this->repository->getAll();
    }
}