<?php

namespace Otus\Task13\Product\Application\UseCase;


use Otus\Task13\Core\ORM\Contract\CollectionInterface;
use Otus\Task13\Product\Application\Contract\GetProductsUseCaseInterface;
use Otus\Task13\Product\Domain\Contract\ProductRepositoryInterface;


class GetAllProductUseCase implements GetProductsUseCaseInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }


    public function getAll(): CollectionInterface
    {
        return $this->productRepository->getAll();
    }
}