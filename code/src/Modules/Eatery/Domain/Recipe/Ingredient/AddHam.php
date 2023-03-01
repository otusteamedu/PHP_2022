<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\IngredientEnum;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\AddIngredient;

class AddHam extends AddIngredient
{
    public function cook(): array
    {
        $recipe = parent::cook();
        $recipe[] = IngredientEnum::HAM->value;

        return $recipe;
    }
}