<?php

namespace App\ProductFactory;

use App\Product\ProductInterface;
use App\Strategy\CheeseBurgerStrategy;

class BurgerFactory extends AbstractProductFactory
{
    protected array $availableStrategies = [
        CheeseBurgerStrategy::class,
    ];
}
