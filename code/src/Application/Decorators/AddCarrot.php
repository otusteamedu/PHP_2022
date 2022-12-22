<?php

namespace Otus\App\Application\Decorators;

use Otus\App\Domain\Model\Controllers\Product;
use Otus\App\Domain\Model\Interface\ProductInterface;

class AddCarrot extends Product implements ProductInterface
{
    public function getName(): string
    {
        return $this->product->getName()." дополнительно морковка";
    }

}