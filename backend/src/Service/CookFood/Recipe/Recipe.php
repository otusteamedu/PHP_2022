<?php

namespace App\Service\CookFood\Recipe;

use App\Service\CookFood\Ingredient\IngredientInterface;
use App\Service\CookFood\Ingredient\IngredientList;

class Recipe implements RecipeInterface
{
    private array $steps = [];
    private IngredientList $ingredientList;

    public function __construct()
    {
        $this->ingredientList = new IngredientList();
    }

    public function getIngredientList(): IngredientList
    {
        return $this->ingredientList;
    }

    public function setIngredientList(IngredientList $list): void
    {
        $this->ingredientList = $list;
    }

    public function getSteps(): array
    {
        return $this->steps;
    }

    public function addIngredientToList(IngredientInterface $ingredient)
    {
        $this->ingredientList->add($ingredient);
    }
}