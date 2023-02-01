<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Bread;
use DKozlov\Otus\Domain\Value\Salad;
use DKozlov\Otus\Domain\Value\Sausage;

class Sandwich extends AbstractProduct
{
    public function who(): string
    {
        return 'сендвич';
    }

    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = new Bread();

        $receipt
            ->setNextIngredient(new Salad())
            ->setNextIngredient(new Sausage());

        return $receipt;
    }
}