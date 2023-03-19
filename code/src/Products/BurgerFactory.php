<?php

namespace Ppro\Hw20\Products;

use Ppro\Hw20\Recipes\RecipeStrategyInterface;

class BurgerFactory implements ProductFactoryInterface
{
    public function create(): ProductInterface
    {
        return new Burger();
    }
}