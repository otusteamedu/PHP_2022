<?php

namespace Ppro\Hw20\Products;

use Ppro\Hw20\Recipes\RecipeStrategyInterface;

class HotdogFactory implements ProductFactoryInterface
{
    public function create(): ProductInterface
    {
        return new Hotdog();
    }
}