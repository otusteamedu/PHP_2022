<?php

namespace App\Listener;

use App\Product\ProductInterface;

class ProductIsReadyListener implements EventListenerInterface
{
    public function handle(ProductInterface $product)
    {
        // тут необходимые действия на результат
        var_dump('ready');
    }
}
