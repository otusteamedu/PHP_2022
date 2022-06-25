<?php

namespace App\Service\CookingFood\Product;

use App\Service\CookingFood\Ingredient\IngredientList;
use App\Service\CookingFood\Recipe\RecipeInterface;

class Product implements ProductInterface
{
    private RecipeInterface $recipe;

    public function __construct(
        private readonly ProductEnum $type
    )
    {
    }

    public function getIngredientList(): IngredientList
    {
        return $this->recipe->getIngredientList();
    }

    public function setRecipe(RecipeInterface $recipe): void
    {
        $this->recipe = $recipe;
    }

    public function getRecipe(): RecipeInterface
    {
        return $this->recipe;
    }

    public function getType(): ProductEnum
    {
        return $this->type;
    }
}