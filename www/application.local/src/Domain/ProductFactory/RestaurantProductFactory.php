<?php

declare(strict_types=1);

namespace app\Domain\ProductFactory;

use app\Domain\Model\Product\Burger\RestaurantBurger;
use app\Domain\Model\Product\Hotdog\RestaurantHotdog;
use app\Domain\Model\Product\Sandwich\RestaurantSandwich;

class RestaurantProductFactory implements ProductFactoryInterface
{
    public function createBaseBurger(): RestaurantBurger
    {
        return new RestaurantBurger();
    }

    public function createBaseHotdog(): RestaurantHotdog
    {
        return new RestaurantHotdog();
    }

    public function createBaseSandwich(): RestaurantSandwich
    {
        return new RestaurantSandwich();
    }
}
