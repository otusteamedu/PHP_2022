<?php

namespace Otus\Task14\Factory;


use Otus\Task14\Factory\Contract\ProductInterface;
use Otus\Task14\Factory\Contract\ProductFactoryInterface;
use Otus\Task14\Factory\Products\HotDogProduct;

class HotDogProductFactory implements ProductFactoryInterface
{
    public function make(): ProductInterface
    {
        return new HotDogProduct();
    }
}