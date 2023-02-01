<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Observer;

use DKozlov\Otus\Application\Observer\Interface\ProductSubscriberInterface;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

class ProductSubscriber implements ProductSubscriberInterface
{
    public function update(ProductInterface $product): void
    {
        echo 'Слежу за приготовлением "' . $product->who() . '"<br>';
    }
}