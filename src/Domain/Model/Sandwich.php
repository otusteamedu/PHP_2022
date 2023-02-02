<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;

class Sandwich extends AbstractProduct
{
    public function who(): string
    {
        return 'сендвич';
    }

    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = $this->ingredientFactory->buildBread();

        $receipt
            ->setNextIngredient($this->ingredientFactory->buildSalad())
            ->setNextIngredient($this->ingredientFactory->buildSausage());

        return $receipt;
    }
}