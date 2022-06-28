<?php

namespace App\Service\CookingFood\Cooking;

use App\Service\CookingFood\Event\PreCookingEvent;
use App\Service\CookingFood\Event\PostCookingEvent;
use App\Service\CookingFood\Product\ProductInterface;
use App\Service\CookingFood\Event\Manager\EventManagerInterface;

class CookingProductProxy implements CookingInterface
{
    public function __construct(
        private readonly CookingInterface      $cooking,
        private readonly EventManagerInterface $eventManager,
    )
    {
    }

    public function cooking(ProductInterface $product): void
    {
        $preEvent = new PreCookingEvent($product, $this->eventManager);
        $preEvent->notify();
        $this->cooking->cooking($product);
        $postEvent = new PostCookingEvent($product, $this->eventManager);
        $postEvent->notify();
    }
}