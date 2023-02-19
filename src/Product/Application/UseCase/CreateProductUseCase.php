<?php

namespace Otus\Task13\Product\Application\UseCase;

use Otus\Task13\Product\Application\Contract\CreateProductUseCaseInterface;
use Otus\Task13\Product\Application\Dto\Request\CreateProductRequestDto;
use Otus\Task13\Product\Application\Dto\Response\CreateProductResponseDto;
use Otus\Task13\Product\Domain\Contract\ProductRepositoryInterface;
use Otus\Task13\Product\Domain\Entity\ProductEntity;
use Otus\Task13\Product\Domain\ValueObject\ProductDescription;
use Otus\Task13\Product\Domain\ValueObject\ProductTitle;

class CreateProductUseCase implements CreateProductUseCaseInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productDao)
    {
    }

    public function create(CreateProductRequestDto $dto): CreateProductResponseDto
    {
        $product = $this->mapperDtoToEntity($dto);
        return $this->productDao->create($product);
    }

    private function mapperDtoToEntity(CreateProductRequestDto $createProductRequestDto): ProductEntity
    {

        return new ProductEntity(
            title: new ProductTitle($createProductRequestDto->name),
            description: new ProductDescription($createProductRequestDto->description)
        );
    }

}