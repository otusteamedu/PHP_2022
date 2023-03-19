<?php

namespace Ppro\Hw20\Observers;

use Ppro\Hw20\Products\ProductInterface;

interface ProductPublisherInterface
{
    public function subscribe(ProductSubscriberInterface $subscriber);
    public function unsubscribe(ProductSubscriberInterface $subscriber);
    public function notify(ProductInterface $product);
}