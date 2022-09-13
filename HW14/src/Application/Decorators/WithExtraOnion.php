<?php

declare(strict_types=1);

namespace App\Application\Decorators;

use App\Application\Controllers\Product;
use App\Domain\Contracts\ProductInterface;

class WithExtraOnion extends Product implements ProductInterface, \SplSubject
{
    protected ProductInterface $product;

    /**
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    public function getName(): string
    {
        return $this->product->getName()." с двойным луком";
    }

    public function getPrice(): float
    {
        return $this->product->getPrice()+5.0;
    }
}