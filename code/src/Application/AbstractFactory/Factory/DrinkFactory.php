<?php

declare(strict_types=1);

namespace App\Application\AbstractFactory\Factory;

use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Application\Product\Drink\CoffeeProduct;
use App\Application\Product\Drink\TeaProduct;

/**
 * DrinkFactory
 */
class DrinkFactory
{
    /**
     * @return CoffeeProduct
     */
    public function createCoffee(): ProductInterface
    {
          return new CoffeeProduct();
    }

    /**
     * @return TeaProduct
     */
    public function createTea(): ProductInterface
    {
        return new TeaProduct();
    }
}