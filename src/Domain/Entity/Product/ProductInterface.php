<?php

namespace App\Domain\Entity\Product;

use App\Domain\Enum\Ingredient;

interface ProductInterface
{
    /**
     * @return array<Ingredient>
     */
    public function getIngredients(): array;

    public function show(): void;
}