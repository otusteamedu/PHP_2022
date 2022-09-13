<?php

namespace App\Application\Factories;

use App\Application\Controllers\HotDog;
use App\Application\Controllers\Sandwich;
use App\Domain\Contracts\ProductInterface;

class ProductAbstractFactory
{

    public function create($type) : ProductFactoryInterface {
        if ($type == ProductInterface::TYPE_HOTDOG)
        {
            return new HotDogFactory();
        }
        else if ($type == ProductInterface::TYPE_BURGER)
        {
            return new BurgerFactory();
        }
        else if ($type == ProductInterface::TYPE_SANDWICH)
        {
            return new SandwichFactory();
        }
        else
            throw new \InvalidArgumentException('Wrong product type!');
    }
}