<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe;

interface Recipe
{
    /**
     * @return array
     */
    public function cook(): array;
}