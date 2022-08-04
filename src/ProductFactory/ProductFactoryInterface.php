<?php

namespace App\ProductFactory;

use App\Product\ProductInterface;

interface ProductFactoryInterface
{

    public function makeProduct(): ProductInterface;

}
