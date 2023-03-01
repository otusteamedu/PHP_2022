<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe;

class FoodRecipe implements Recipe
{
    private array $ingredients;

    /**
     * @param array|null $ingredients
     */
    public function __construct(?array $ingredients)
    {
        $ingredients = array_map(static fn($ingredient) => $ingredient->value, $ingredients);
        $this->ingredients = $ingredients ?? array();
    }

    /**
     * @return array
     */
    public function cook(): array
    {
        return $this->ingredients;
    }
}