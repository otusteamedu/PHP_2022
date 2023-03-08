<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Strategy;

use SGakhramanov\Patterns\Classes\Proxies\MakeHotDogProxy;
use SGakhramanov\Patterns\Classes\Proxies\MakeSandwichProxy;
use SGakhramanov\Patterns\Interfaces\Products\BurgerInterface;
use SGakhramanov\Patterns\Interfaces\Products\HotDogInterface;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;
use SGakhramanov\Patterns\Classes\Proxies\MakeBurgerProxy;
use SGakhramanov\Patterns\Interfaces\Products\SandwichInterface;

class ProductProxyStrategy
{
    public function getProxy(ProductInterface $product)
    {
        if ($product instanceof BurgerInterface) {
            return new MakeBurgerProxy($product);
        } elseif ($product instanceof HotDogInterface) {
            return new MakeHotDogProxy($product);
        } elseif ($product instanceof SandwichInterface) {
            return new MakeSandwichProxy($product);
        }
    }
}
