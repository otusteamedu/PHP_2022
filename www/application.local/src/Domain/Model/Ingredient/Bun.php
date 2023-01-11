<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Bun extends AbstractIngredient {
    protected string $name = 'Булочка';
    protected int $price = 2;
}
