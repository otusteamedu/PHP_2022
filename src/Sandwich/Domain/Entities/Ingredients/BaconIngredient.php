<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Entities\Ingredients;

use Src\Sandwich\Domain\Contracts\Ingredient;

final class BaconIngredient implements Ingredient
{
    /**
     * @var int
     */
    private int $quantity;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'Бекон в количестве ' . $this->getQuantity() . 'шт.';
    }

    /**
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
