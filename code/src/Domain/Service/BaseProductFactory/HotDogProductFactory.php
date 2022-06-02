<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\BaseProductFactory;


use Decole\Hw18\Domain\Entity\Product\Hotdog;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;

class HotDogProductFactory implements BaseProductPrepareFactoryInterface
{
    public function prepare(): ProductInterface
    {
        return new Hotdog();
    }
}