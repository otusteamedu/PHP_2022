<?php

namespace App\Product\Ingredients;

use App\Product\ProductInterface;

abstract class AbstractIngredient
{

    public function __construct(
        private readonly ?AbstractIngredient $ingredient = null
    ){}


    public function addIngredientToProduct(ProductInterface $product): void
    {
        $product->addIngredient($this);
        $this->ingredient?->addIngredientToProduct($product);
    }


    abstract public function getIngredient(): string;


}
