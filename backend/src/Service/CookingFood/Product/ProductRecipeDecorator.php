<?php

namespace App\Service\CookingFood\Product;

use App\Service\CookingFood\Ingredient\IngredientList;
use App\Service\CookingFood\Recipe\RecipeInterface;

class ProductRecipeDecorator implements ProductInterface
{
    public function __construct(
        private readonly ProductInterface $product,
        private readonly RecipeInterface  $recipe,
    )
    {
        $this->product->setRecipe($this->recipe);
    }

    public function getIngredientList(): IngredientList
    {
        return $this->recipe->getIngredientList();
    }

    public function setRecipe(RecipeInterface $recipe): void
    {
        $this->product->setRecipe($recipe);
    }

    public function getRecipe(): RecipeInterface
    {
        return $this->product->getRecipe();
    }
}