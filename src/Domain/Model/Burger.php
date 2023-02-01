<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Bread;
use DKozlov\Otus\Domain\Value\Cutlet;
use DKozlov\Otus\Domain\Value\Salad;
use DKozlov\Otus\Domain\Value\Tomato;

class Burger extends AbstractProduct
{
    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = new Bread();

        $receipt
            ->setNextIngredient(new Salad())
            ->setNextIngredient(new Cutlet())
            ->setNextIngredient(new Tomato());

        return $receipt;
    }

    public function who(): string
    {
        return 'бургер';
    }
}