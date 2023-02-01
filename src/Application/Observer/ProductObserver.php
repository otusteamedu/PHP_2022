<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Observer;

use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductSubscriberInterface;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

class ProductObserver implements ProductObserverInterface
{
    /**
     * @var ProductSubscriberInterface[]
     */
    private array $subscribers = [];

    public function notify(ProductInterface $product): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($product);
        }
    }

    public function subscribe(ProductSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }
}