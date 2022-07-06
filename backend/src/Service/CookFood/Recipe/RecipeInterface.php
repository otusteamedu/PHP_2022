<?php

namespace App\Service\CookFood\Recipe;

use App\Service\CookFood\Ingredient\IngredientInterface;
use App\Service\CookFood\Ingredient\IngredientList;

interface RecipeInterface
{
    public function getIngredientList(): IngredientList;

    public function setIngredientList(IngredientList $list): void;

    public function addIngredientToList(IngredientInterface $ingredient);

    public function getSteps(): array;
}