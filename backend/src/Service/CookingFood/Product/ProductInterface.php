<?php

namespace App\Service\CookingFood\Product;

use App\Service\CookingFood\Ingredient\IngredientList;
use App\Service\CookingFood\Recipe\RecipeInterface;

interface ProductInterface
{
    public function getIngredientList(): IngredientList;

    public function setRecipe(RecipeInterface $recipe): void;

    public function getRecipe(): RecipeInterface;
}