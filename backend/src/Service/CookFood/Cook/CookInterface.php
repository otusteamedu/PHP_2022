<?php

namespace App\Service\CookFood\Cook;

use App\Service\CookFood\Product\ProductInterface;

interface CookInterface
{
    public function cooking(ProductInterface $product): void;
}