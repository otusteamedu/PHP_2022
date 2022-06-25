<?php

namespace App\Service\CookingFood\Cooking;

use App\Service\CookingFood\Product\ProductInterface;

interface CookingInterface
{
    public function cooking(ProductInterface $product): void;
}