<?php

namespace App\Listener;

use App\Product\ProductInterface;

interface EventListenerInterface
{
    public function handle(ProductInterface $product);
}
