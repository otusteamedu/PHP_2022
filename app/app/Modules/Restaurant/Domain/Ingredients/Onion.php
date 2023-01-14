<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

class Onion implements IngredientInterface
{
    public function getName(): string
    {
        return 'лук';
    }
}
