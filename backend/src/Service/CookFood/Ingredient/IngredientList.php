<?php

namespace App\Service\CookFood\Ingredient;

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