<?php

namespace App\Strategy;

use App\Product\Ingredients\BunIngredient;
use App\Product\Ingredients\CheeseIngredient;
use App\Product\Ingredients\CutletIngredient;
use App\Product\ProductInterface;

class CheeseBurgerStrategy implements StrategyInterface
{

    public function make(ProductInterface $product)
    {
        $ingredient = new BunIngredient();
        $ingredient = new CheeseIngredient($ingredient);
        $ingredient = new CutletIngredient($ingredient);
        $ingredient = new BunIngredient($ingredient);

        $ingredient->addIngredientToProduct($product);
    }
}
