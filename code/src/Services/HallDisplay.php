<?php

namespace Ppro\Hw20\Services;

use Ppro\Hw20\Observers\ProductSubscriberInterface;
use Ppro\Hw20\Products\ProductInterface;

/** Вывод статуса приготовления (Наблюдатель - реализация подписчика)
 *
 */
class HallDisplay implements ProductSubscriberInterface
{
    /** Вывод статуса приготовления
     * @param ProductInterface $product
     * @return void
     */
    public function update(ProductInterface $product)
    {
        echo '#HallDisplay: '.$product->getProductObject()->getStatus();
    }
}