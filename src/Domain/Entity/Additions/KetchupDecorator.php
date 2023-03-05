<?php

declare(strict_types=1);

namespace App\Domain\Entity\Additions;

use App\Domain\Entity\Product\ProductInterface;
use App\Domain\Enum\Ingredient;

class KetchupDecorator implements ProductInterface
{
    public function __construct(private readonly ProductInterface $product)
    {
    }

    /**
     * @inheritDoc
     */
    public function getIngredients(): array
    {
        return \array_merge($this->product->getIngredients(), [Ingredient::KETCHUP]);
    }
}