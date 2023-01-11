<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Bread extends AbstractIngredient {
    protected string $name = 'Хлеб';
    protected int $price = 1;
}
