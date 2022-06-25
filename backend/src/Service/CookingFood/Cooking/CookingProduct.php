<?php

namespace App\Service\CookingFood\Cooking;

use App\Service\CookingFood\Product\ProductInterface;

class CookingProduct implements CookingInterface
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