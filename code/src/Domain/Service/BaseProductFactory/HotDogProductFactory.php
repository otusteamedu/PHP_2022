<?php


namespace Decole\Hw18\Domain\Service\BaseProductStrategy;


use Decole\Hw18\Domain\Entity\Product\Hotdog;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;

class HotDogProductFactory implements BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface
    {
        return new Hotdog();
    }
}