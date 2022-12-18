<?php

namespace Otus\App\Application\Decorators;

use Otus\App\Application\Controllers\Product;
use Otus\App\Domain\ProductInterface;

class AddBacon extends Product implements ProductInterface
{
    public function getName(): string
    {
        return $this->product->getName()." дополнительная ветчина";
    }

}