<?php


namespace Decole\Hw18\Domain\Service\BaseProductStrategy;


use Decole\Hw18\Domain\Entity\Product\Burger;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;

class BurgerProductFactory implements BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface
    {
        return new Burger();
    }
}