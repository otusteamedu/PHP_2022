<?php

namespace App\Service\CookFood\Cook;

use App\Service\CookFood\Product\ProductInterface;

class CookProduct implements CookInterface
{
    public function cooking(ProductInterface $product): void
    {
        $product->getIngredientList();
        $steps = $product->getRecipe()->getSteps();
        foreach ($steps as $step) {
            $this->doStep($step);
        }
    }

    private function doStep($step)
    {
        //
    }
}