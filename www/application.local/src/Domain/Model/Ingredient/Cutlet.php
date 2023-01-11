<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

class Cutlet extends AbstractIngredient {
    protected string $name = 'Котлета';
    protected int $price = 3;
}
