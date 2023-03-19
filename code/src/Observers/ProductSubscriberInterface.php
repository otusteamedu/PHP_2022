<?php

namespace Ppro\Hw20\Observers;

use Ppro\Hw20\Products\ProductInterface;

interface ProductSubscriberInterface
{
    public function update(ProductInterface $product);
}