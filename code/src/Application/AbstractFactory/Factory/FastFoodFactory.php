<?php

declare(strict_types=1);

namespace App\Application\AbstractFactory\Factory;

use App\Application\AbstractFactory\Contract\ProductFactoryInterface;
use App\Application\Product\FastFood\BurgerProduct;
use App\Application\Product\FastFood\HotdogProduct;
use App\Application\Product\FastFood\SandwichProduct;

/**
 * FastFoodFactory
 */
class FastFoodFactory implements ProductFactoryInterface
{
    /**
     * @return BurgerProduct
     */
    public static function createBurger(): BurgerProduct
    {
          return new BurgerProduct();
    }

    /**
     * @return HotdogProduct
     */
    public static function createHotDog(): HotdogProduct
    {
        return new HotdogProduct();
    }

    /**
     * @return SandwichProduct
     */
    public static function createSandwich(): SandwichProduct
    {
        return new SandwichProduct();
    }
}