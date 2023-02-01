<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model\Proxy;

use DKozlov\Otus\Domain\Model\Burger;
use DKozlov\Otus\Domain\Value\Interface\IngredientInterface;

class BurgerProxy extends Burger
{
    public function addIngredient(IngredientInterface $ingredient): void
    {
        echo 'Проверка свежести "' . $ingredient->name() . '"<br>';

        parent::addIngredient($ingredient);
    }
}