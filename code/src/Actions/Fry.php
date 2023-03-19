<?php

namespace Ppro\Hw20\Actions;

use Ppro\Hw20\Products\ProductInterface;

/** Жарим и добавляем игредиент в готовое блюдо
 *
 */
class Fry extends CookAction
{
    public function handle(ProductInterface $product): void
    {
        array_walk($this->ingredient,fn(&$ingredient,$key,$operation):string => $ingredient = $operation.$ingredient,'Fried ');
        $product->getProductObject()->setFinishedProduct(array_merge($product->getProductObject()->getFinishedProduct(),$this->ingredient));
        parent::handle($product);
    }
}