<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe;

use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;

class FoodRecipe implements Recipe
{
    private array $ingredients;

    /**
     * @return array
     */
    public function cook(): array
    {
        return $this->ingredients;
    }

    public function addIngredients(?Ingredients $ingredients)
    {
        if ($ingredients) {
            $ingredients = $ingredients->get();
            $ingredients = array_map(static fn($ingredient) => $ingredient->value, $ingredients);
            $this->ingredients = $ingredients ?? array();
        }
    }
}