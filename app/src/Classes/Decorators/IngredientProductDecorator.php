<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Decorators;

use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;

class IngredientProductDecorator implements ProductInterface
{
    private ProductInterface $product;
    private array $ingredients;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function setIngredientExtra($ingredient)
    {
        $this->ingredients = $ingredient;
    }

    public function make()
    {
        array_walk($this->ingredients, fn($ingredient) => $this->product->ingredients[] = $ingredient);

        return $this->product->make();
    }
}
