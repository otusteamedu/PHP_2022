<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\UseCases\Recipes;

use Src\Sandwich\Domain\Contracts\Recipe;

final class HotDogRecipe implements Recipe
{
    /**
     * @return array
     */
    public function get(): array
    {
        return [
            'Onion' => 1,
            'Tomato' => 1,
            'Bacon' => 1,
        ];
    }
}
