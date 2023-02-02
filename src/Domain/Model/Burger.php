<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;

class Burger extends AbstractProduct
{
    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = $this->ingredientFactory->buildBread();

        $receipt
            ->setNextIngredient($this->ingredientFactory->buildSalad())
            ->setNextIngredient($this->ingredientFactory->buildCutlet())
            ->setNextIngredient($this->ingredientFactory->buildTomato());

        return $receipt;
    }

    public function who(): string
    {
        return 'бургер';
    }
}