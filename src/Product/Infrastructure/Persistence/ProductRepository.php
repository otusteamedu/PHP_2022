<?php

namespace Otus\Task13\Product\Infrastructure\Persistence;

use Otus\Task13\Core\ORM\Collection;
use Otus\Task13\Core\ORM\Contract\EntityManagerContract;
use Otus\Task13\Product\Application\Dto\Response\CreateProductResponseDto;
use Otus\Task13\Product\Domain\Contract\ProductRepositoryInterface;
use Otus\Task13\Product\Domain\Entity\ProductEntity;
use Otus\Task13\Product\Infrastructure\Persistence\Entity\ProductEntityPersistence;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerContract $entityManager,
    )
    {
    }

    /**
     * @param ProductEntity $product
     * @return CreateProductResponseDto
     */
    public function create(ProductEntity $product): CreateProductResponseDto
    {
        $productEntity = new ProductEntityPersistence();
        $productEntity->setName($product->getTitle());

        /**  @var ProductEntityPersistence $product */
        $product = $this->entityManager->create($productEntity);

        return new CreateProductResponseDto(
            id: $product->getId(), name: $product->getName(), description: $product->getDescription()
        );
    }

    public function getAll(): Collection
    {
        return $this->entityManager->getRepository(ProductEntityPersistence::class)->all();
    }
}