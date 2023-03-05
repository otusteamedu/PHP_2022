<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Product\ProductInterface;
use App\Domain\Entity\Product\Sandwich;
use App\Domain\Enum\Ingredient;

class SandwichCreator implements ProductCreatorInterface
{
    public function create(): ProductInterface
    {
        return new Sandwich([
            Ingredient::BREAD,
            Ingredient::CHICKEN,
            Ingredient::CHEESE,
        ]);
    }
}