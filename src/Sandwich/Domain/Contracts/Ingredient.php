<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts;

interface Ingredient
{
    /**
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void;

    /**
     * @return int
     */
    public function getQuantity(): int;
}
