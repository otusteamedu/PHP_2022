<?php

namespace App\Product;

use App\Product\Ingredients\AbstractIngredient;

interface ProductInterface
{

    public function addIngredient(AbstractIngredient $ingredient): self;

    public function getIngredients(): array;

}
