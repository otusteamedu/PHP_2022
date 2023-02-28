<?php

namespace App\Product;

use App\Product\Ingredients\AbstractIngredient;
use App\Product\Ingredients\BunIngredient;

class ProductProxy implements ProductInterface
{
    private ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }


    public function addIngredient(AbstractIngredient $ingredient): ProductInterface
    {
        $this->product->addIngredient($ingredient);

        return $this;
    }


    public function getIngredients(): array
    {
        $ingredients = $this->product->getIngredients();

        // тут проверка качества продукта
        if (!count($ingredients)) {
            throw new \Exception('Продукт не может быть без ингредиентов');
        }

        if ($ingredients[0]::class !== BunIngredient::class) {
            throw new \Exception('Нижняя часть должна быть булкой');
        }

        return array_map(fn (AbstractIngredient $ingredient) => $ingredient->getIngredient(), $ingredients);
    }
}
