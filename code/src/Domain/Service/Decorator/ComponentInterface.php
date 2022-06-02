<?php


namespace Decole\Hw18\Domain\Service\Decorator;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;

interface ComponentInterface
{
    public function __construct($component);

    public function joinToBaseProduct(ProductInterface $baseProduct): ProductInterface;
}