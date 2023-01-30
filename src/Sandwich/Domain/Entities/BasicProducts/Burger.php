<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Entities\BasicProducts;

use Src\Sandwich\Domain\Contracts\BasicProduct;

class Burger implements BasicProduct
{
    /**
     * @var string
     */
    private string $basic_product_name;

    /**
     * @param string $basic_product_name
     */
    public function __construct(string $basic_product_name)
    {
        $this->basic_product_name = $basic_product_name;
    }

    /**
     * @return array
     */
    public function cook(): array
    {
        return ['basic_product' => $this->basic_product_name];
    }
}
