<?php


namespace Decole\Hw18\Domain\Service\BaseProductStrategy;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;

interface BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface;
}