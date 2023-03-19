<?php

namespace Ppro\Hw20\Actions;

use Ppro\Hw20\Exceptions\AppException;
use Ppro\Hw20\Products\ProductFactoryInterface;
use Ppro\Hw20\Products\ProductInterface;

/** Добавляем игредиент в готовое блюдо
 *
 */
class Add extends CookAction
{
    public function handle(ProductInterface $product): void
    {
        $product->getProductObject()->setFinishedProduct(array_merge($product->getProductObject()->getFinishedProduct(),$this->ingredient));
        parent::handle($product);
    }
}