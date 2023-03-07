<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;

class DefaultHandler extends BaseHandler
{
    public function handle(Order $order): void
    {
        // ...
    }
}