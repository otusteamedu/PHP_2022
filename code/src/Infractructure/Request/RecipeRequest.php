<?php

namespace App\Infractructure\Request;

/**
 * RecipeRequest
 */
class RecipeRequest implements RequestInterface
{
    /**
     * @var array|string[]
     */
    private array $ingredients = ['Salad'];

    /**
     * @return array|string[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}