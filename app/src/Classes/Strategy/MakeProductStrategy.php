<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Strategy;

use SGakhramanov\Patterns\Interfaces\Strategy\MakeProductStrategyInterface;
use SGakhramanov\Patterns\Classes\Factories\ProductsFactory;
use SGakhramanov\Patterns\Classes\Services\SendMessageService;
use SGakhramanov\Patterns\Classes\Observers\Notifier;

class MakeProductStrategy implements MakeProductStrategyInterface
{
    public function makeProductByCalories(int $maxCalories)
    {
        //Наблюдатель
        $notifier = new Notifier();
        $notifier->subscribe(new SendMessageService());
        //Абстрактная фабрика
        $productFactory = new ProductsFactory();

        if ($maxCalories <= 300) {
            return $productFactory->makeSandwich($notifier);
        } elseif ($maxCalories <= 400) {
            return $productFactory->makeHotDog($notifier);
        } elseif ($maxCalories <= 500) {
            return $productFactory->makeBurger($notifier);
        }
    }
}
