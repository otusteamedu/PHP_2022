<?php

namespace Otus\App\Application\Decorators;

use Otus\App\Application\Controllers\Product;
use Otus\App\Domain\ProductInterface;

class AddPepper extends Product implements ProductInterface
{
    public function getName(): string
    {
        return $this->product->getName()." дополнительный перец";
    }

}