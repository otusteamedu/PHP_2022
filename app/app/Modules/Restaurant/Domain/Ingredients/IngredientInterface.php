<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

interface IngredientInterface
{
    public function getName(): string;
}
