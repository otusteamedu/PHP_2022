<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Salad extends AbstractIngredient {
    protected string $name = 'Салат';
    protected int $price = 6;
}
