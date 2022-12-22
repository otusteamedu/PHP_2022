<?php

namespace Otus\App\Application\Proxy;

use Otus\App\Domain\Model\Controllers\Product;
use Otus\App\Domain\Model\Interface\ProductInterface;

class TasterProducts extends Product
{
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    public function standardsCompliance():bool
    {
        if (stripos($this->product->getName(), 'булка' )) {
            return true;
        } else {
            return false;
        }
    }
}