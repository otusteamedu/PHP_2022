<?php

declare(strict_types=1);

namespace App\Application\AbstractFactory\Factory;

use App\Application\AbstractFactory\Contract\ProductFactoryInterface;
use App\Application\AbstractFactory\Contract\ProductInterface;
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
    public function createBurger(): ProductInterface
    {
          return new BurgerProduct();
    }

    /**
     * @return HotdogProduct
     */
    public function createHotDog(): ProductInterface
    {
        return new HotdogProduct();
    }

    /**
     * @return SandwichProduct
     */
    public function createSandwich(): ProductInterface
    {
        return new SandwichProduct();
    }
}