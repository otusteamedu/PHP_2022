<?php

namespace App\Listener;

use App\Product\ProductInterface;

class ProductStartedCookingListener implements EventListenerInterface
{

    public function handle(ProductInterface $product)
    {
        // тут необходимые действия, когда продукт только начинают готовить
    }

}
