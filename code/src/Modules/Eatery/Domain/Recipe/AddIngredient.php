<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe;

class AddIngredient implements Recipe
{
    protected Recipe $recipe;

    /**
     * @param Recipe $recipe
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @return array
     */
    public function cook(): array
    {
        return $this->recipe->cook();
    }
}