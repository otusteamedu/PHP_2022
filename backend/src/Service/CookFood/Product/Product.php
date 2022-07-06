<?php

namespace App\Service\CookFood\Product;

use App\Service\CookFood\Ingredient\IngredientList;
use App\Service\CookFood\Recipe\RecipeInterface;

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