<?php

namespace App\Service\CookFood\Product;

use App\Service\CookFood\Ingredient\IngredientList;
use App\Service\CookFood\Recipe\RecipeInterface;

interface ProductInterface
{
    public function getIngredientList(): IngredientList;

    public function setRecipe(RecipeInterface $recipe): void;

    public function getRecipe(): RecipeInterface;
}