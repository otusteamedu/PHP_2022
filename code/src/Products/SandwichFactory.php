<?php

namespace Ppro\Hw20\Products;

class SandwichFactory implements ProductFactoryInterface
{
    public function create(): ProductInterface
    {
        return new Sandwich();
    }
}