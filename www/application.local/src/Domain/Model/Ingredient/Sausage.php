<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Sausage extends AbstractIngredient {
    protected string $name = 'Колбаса';
    protected int $price = 7;
}
