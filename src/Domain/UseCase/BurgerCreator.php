<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Product\Burger;
use App\Domain\Entity\Product\ProductInterface;
use App\Domain\Enum\Ingredient;

class BurgerCreator implements ProductCreatorInterface
{
    public function create(): ProductInterface
    {
        return new Burger([
            Ingredient::BUN,
            Ingredient::BEEF,
            Ingredient::LETTUCE,
        ]);
    }
}