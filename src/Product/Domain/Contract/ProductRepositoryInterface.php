<?php

namespace Otus\Task13\Product\Domain\Contract;

use Otus\Task13\Product\Application\Dto\Response\CreateProductResponseDto;
use Otus\Task13\Product\Domain\Entity\ProductEntity;

interface ProductRepositoryInterface
{
    public function create(ProductEntity $product): CreateProductResponseDto;

}