<?php

namespace App\Service\CookFood\Cook;

use App\Service\CookFood\Event\PreCookEvent;
use App\Service\CookFood\Event\PostCookEvent;
use App\Service\CookFood\Product\ProductInterface;
use App\Service\CookFood\Event\Manager\EventManagerInterface;

class CookProductProxy implements CookInterface
{
    public function __construct(
        private readonly CookInterface         $cooking,
        private readonly EventManagerInterface $eventManager,
    )
    {
    }

    public function cooking(ProductInterface $product): void
    {
        $preEvent = new PreCookEvent($product, $this->eventManager);
        $preEvent->notify();
        $this->cooking->cooking($product);
        $postEvent = new PostCookEvent($product, $this->eventManager);
        $postEvent->notify();
    }
}