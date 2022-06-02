<?php


namespace Decole\Hw18\Domain\Entity\Product;


use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototypeInterface;

interface ProductInterface
{
    public function getType(): string;

    public function join(InnerProductPrototypeInterface $product): void;

    public function getInnerPrototypeProducts(): array;

    public function getIterator(): \Iterator;

    public function getReverseIterator(): \Iterator;
}