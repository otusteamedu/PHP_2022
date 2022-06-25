<?php

namespace App\Service\CookingFood\Ingredient;

class IngredientList
{
    private $items = [];

    public function add(IngredientInterface $ingredient): void
    {
        $this->items[] = $ingredient;
    }

    public function list(): array
    {
        return $this->items;
    }
}