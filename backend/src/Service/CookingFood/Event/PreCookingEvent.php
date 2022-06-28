<?php

namespace App\Service\CookingFood\Event;

use App\Service\CookingFood\Product\ProductInterface;
use App\Service\CookingFood\Event\Manager\EventManagerInterface;

class PreCookingEvent extends AbstractEvent
{
    public function __construct(
        private readonly ProductInterface $product,
        EventManagerInterface             $eventManager,
    )
    {
        parent::__construct($eventManager);
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }
}