<?php

namespace App\Product;

use App\Product\Ingredients\AbstractIngredient;

class Product implements ProductInterface
{
    private array $ingredients = [];


    public function addIngredient(AbstractIngredient $ingredient): self
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }


    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}
