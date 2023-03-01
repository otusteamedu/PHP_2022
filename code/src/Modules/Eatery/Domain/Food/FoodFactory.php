<?php

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Food;

interface FoodFactory
{
    /**
     * @return array
     */
    public function createRecipe(): array;
}