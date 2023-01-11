<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Pepper extends AbstractIngredient {
    protected string $name = 'Перец';
    protected int $price = 5;
}
