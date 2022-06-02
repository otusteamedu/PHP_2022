<?php


namespace Decole\Hw18\Domain\Service\BaseProductFactory;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Decole\Hw18\Domain\Entity\Product\Sandwich;

class SandwichProductFactory implements BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface
    {
        return new Sandwich();
    }
}