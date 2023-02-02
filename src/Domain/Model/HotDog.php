<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;

class HotDog extends AbstractProduct
{
    public function who(): string
    {
        return 'хот-дог';
    }

    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = $this->ingredientFactory->buildBread();

        $receipt
            ->setNextIngredient($this->ingredientFactory->buildSauce())
            ->setNextIngredient($this->ingredientFactory->buildSausage());

        return $receipt;
    }
}