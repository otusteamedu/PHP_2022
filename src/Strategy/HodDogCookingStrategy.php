<?php

namespace Otus\Task14\Strategy;

use Otus\Task14\Factory\Contract\ProductInterface;
use Otus\Task14\Strategy\Contract\CookingStrategyInterface;

class HodDogCookingStrategy implements CookingStrategyInterface
{
    public function __construct(private readonly ProductInterface $product)
    {

    }

    public function cooking()
    {
       echo 'Собираем бургер: ' . $this->product->getName();
    }
}