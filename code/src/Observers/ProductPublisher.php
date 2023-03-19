<?php

namespace Ppro\Hw20\Observers;

use Ppro\Hw20\Products\ProductInterface;

/** Наблюдатель (реализация издателя)
 *
 */
class ProductPublisher implements ProductPublisherInterface
{
    private array $subscribers = [];
    public function subscribe(ProductSubscriberInterface $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(ProductSubscriberInterface $subscriber)
    {
        // TODO: Implement unsubscribe() method.
    }

    public function notify(ProductInterface $product)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($product);
        }
    }
}