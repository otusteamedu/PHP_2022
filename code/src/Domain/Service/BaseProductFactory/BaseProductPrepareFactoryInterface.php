<?php


namespace Decole\Hw18\Domain\Service\BaseProductFactory;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;

interface BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface;
}