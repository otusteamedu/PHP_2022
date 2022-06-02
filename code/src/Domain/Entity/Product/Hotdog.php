<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity\Product;


use Decole\Hw18\Domain\Entity\BaseProduct;

class Hotdog extends AbstractProduct
{
    public function getType(): string
    {
        return BaseProduct::HOTDOG;
    }
}