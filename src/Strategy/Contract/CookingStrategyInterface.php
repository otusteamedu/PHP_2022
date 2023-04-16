<?php

namespace Otus\Task14\Strategy\Contract;

use Otus\Task14\Factory\Contract\ProductInterface;

interface CookingStrategyInterface
{
    public function __construct(ProductInterface $product);

    public function cooking();
}