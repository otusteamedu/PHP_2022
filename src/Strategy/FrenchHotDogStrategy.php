<?php

namespace App\Strategy;

use App\Product\Ingredients\BunIngredient;
use App\Product\Ingredients\KetchupIngredient;
use App\Product\Ingredients\SausageIngredient;
use App\Product\ProductInterface;

class FrenchHotDogStrategy implements StrategyInterface
{

    public function make(ProductInterface $product)
    {
        $ingredient = new KetchupIngredient();
        $ingredient = new SausageIngredient($ingredient);
        $ingredient = new BunIngredient($ingredient);

        $ingredient->addIngredientToProduct($product);
    }
}
