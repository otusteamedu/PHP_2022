<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Observer\Interface;

use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

interface ProductObserverInterface
{
    public function notify(ProductInterface $product): void;

    public function subscribe(ProductSubscriberInterface $subscriber): void;
}