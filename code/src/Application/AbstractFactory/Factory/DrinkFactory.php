<?php

declare(strict_types=1);

namespace App\Application\AbstractFactory\Factory;

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
    public static function createCoffee(): CoffeeProduct
    {
          return new CoffeeProduct();
    }

    /**
     * @return TeaProduct
     */
    public static function createTea(): TeaProduct
    {
        return new TeaProduct();
    }
}