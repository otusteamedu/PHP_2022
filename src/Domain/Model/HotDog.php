<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Bread;
use DKozlov\Otus\Domain\Value\Sauce;
use DKozlov\Otus\Domain\Value\Sausage;

class HotDog extends AbstractProduct
{
    public function who(): string
    {
        return 'хот-дог';
    }

    public function getProductReceipt(): AbstractIngredient
    {
        $receipt = new Bread();

        $receipt
            ->setNextIngredient(new Sauce())
            ->setNextIngredient(new Sausage());

        return $receipt;
    }
}