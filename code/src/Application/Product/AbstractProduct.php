<?php

declare(strict_types=1);

namespace App\Application\Product;

use App\Application\AbstractFactory\Contract\ProductInterface;

abstract class AbstractProduct implements ProductInterface
{
    protected array $ingredients = [];

    public function add(ProductInterface $ingredient) : static
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param $ingredient
     * @return $this
     */
    public function setIngredient($ingredient): AbstractProduct
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }
}
