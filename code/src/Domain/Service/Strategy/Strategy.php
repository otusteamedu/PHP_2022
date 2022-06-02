<?php


namespace Decole\Hw18\Domain\Service\Strategy;


use Decole\Hw18\Domain\Entity\Dish;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;

interface Strategy
{
    public function cook(ProductInterface $baseProduct): Dish;
}