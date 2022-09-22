<?php

namespace App\Application\Proxies;

use App\Application\Controllers\Product;
use App\Domain\Contracts\ProductInterface;

class FinalQualityTester extends Product
{
    protected ProductInterface $product;

    /**
     * @param $product
     */
    public function __construct(ProductInterface $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    public function isEveryfingFine():bool {
        //Тестирование качества продукта перед отдачей.
        //Считаем, что завезли просроченный лук и продукты с ним не пускаем и утилизируем
        if (stripos($this->product->getName(), 'лук' ))
            return false;
        else
            return true;
    }
}