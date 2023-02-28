<?php

namespace App\ProductFactory;

use App\Product\ProductInterface;
use App\Strategy\FrenchHotDogStrategy;

class HotDogFactory extends AbstractProductFactory
{
    protected array $availableStrategies = [
        FrenchHotDogStrategy::class,
    ];

}
