<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Entities\BasicProducts;

use Src\Sandwich\Domain\Contracts\BasicProduct;

final class SpoiledBasicProduct implements BasicProduct
{
    public array $ingredients = [];

    /**
     * @return BasicProduct
     */
    public function cook(): BasicProduct
    {
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'Продукт испорчен';
    }
}
