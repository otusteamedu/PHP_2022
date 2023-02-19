<?php

namespace Otus\Task13\Product\Application\Contract;

use Otus\Task13\Product\Application\Dto\Request\CreateProductRequestDto;
use Otus\Task13\Product\Application\Dto\Response\CreateProductResponseDto;

interface CreateProductUseCaseInterface
{
    public function create(CreateProductRequestDto $dto): CreateProductResponseDto;
}