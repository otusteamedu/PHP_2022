<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\UseCases\Recipes;

use Src\Sandwich\Domain\Contracts\Recipe;

final class SandwichRecipe implements Recipe
{
    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'Onion' => 2,
            'Tomato' => 2,
            'Bacon' => 3,
        ];
    }
}
