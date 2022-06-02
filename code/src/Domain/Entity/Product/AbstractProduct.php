<?php

namespace Decole\Hw18\Domain\Entity\Product;

use Decole\Hw18\Domain\Service\Iterator\InnerProductValidateIterator;
use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototypeInterface;

abstract class AbstractProduct  implements ProductInterface
{
    private array $innerPrototypeProducts = [];

    public function join(InnerProductPrototypeInterface $product): void
    {
        $this->innerPrototypeProducts[] = $product;
    }

    public function getInnerPrototypeProducts(): array
    {
        return $this->innerPrototypeProducts;
    }

    public function getIterator(): \Iterator
    {
        return new InnerProductValidateIterator($this->innerPrototypeProducts);
    }

    public function getReverseIterator(): \Iterator
    {
        return new InnerProductValidateIterator($this->innerPrototypeProducts, true);
    }
}