<?php

namespace App\Strategy;

use App\Product\ProductInterface;

class NullStrategy implements StrategyInterface
{

    public function make(ProductInterface $product)
    {
        // ничего не делаем, заглушка
    }
}
