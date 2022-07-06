<?php

namespace App\Service\CookFood\Product;

use ValueError;
use RuntimeException;

class ProductFactory
{
    public function make(string $type): Product
    {
        try {
            return new Product(ProductEnum::from($type));
        } catch (ValueError $e) {
            throw new RuntimeException("Product with type: $type does not exists");
        }
    }
}