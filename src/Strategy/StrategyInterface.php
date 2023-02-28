<?php

namespace App\Strategy;

use App\Product\ProductInterface;

interface StrategyInterface
{
    public function make(ProductInterface $product);
}
