<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

class Sausage implements IngredientInterface
{
    public function getName(): string
    {
        return 'сосиска';
    }
}
