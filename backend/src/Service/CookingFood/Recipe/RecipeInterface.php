<?php

namespace App\Service\CookingFood\Recipe;

use App\Service\CookingFood\Ingredient\IngredientInterface;
use App\Service\CookingFood\Ingredient\IngredientList;

interface RecipeInterface
{
    public function getIngredientList(): IngredientList;

    public function setIngredientList(IngredientList $list): void;

    public function addIngredientToList(IngredientInterface $ingredient);

    public function getSteps(): array;
}