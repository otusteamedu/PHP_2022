<?php

namespace App\Service\CookFood\Event;

use App\Service\CookFood\Product\ProductInterface;
use App\Service\CookFood\Event\Manager\EventManagerInterface;

class PostCookEvent extends AbstractEvent
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