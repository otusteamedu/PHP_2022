<?php

namespace Otus\Task13\Product\Infrastructure\Http\Product;

use Exception;
use Otus\Task13\Product\Application\Contract\GetProductsUseCaseInterface;

class ShowProductsController
{
    public function __construct(
        private readonly GetProductsUseCaseInterface $getProductsUseCase,
    )
    {
    }

    public function __invoke()
    {
        try {
            $products = $this->getProductsUseCase->getAll();
        } catch (Exception $exception) {
            var_dump('Exception: ' . $exception->getMessage());
        }


    }
}