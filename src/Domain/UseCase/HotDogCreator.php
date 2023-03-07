<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Product\HotDog;
use App\Domain\Entity\Product\ProductInterface;
use App\Domain\Enum\Ingredient;

class HotDogCreator implements ProductCreatorInterface
{
    public function create(): ProductInterface
    {
        return new HotDog([
            Ingredient::BUN,
            Ingredient::SAUSAGE,
        ]);
    }
}