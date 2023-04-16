<?php
namespace Otus\Task14;

use Otus\Task14\Decorator\Ingredients\BunIngredient;
use Otus\Task14\Decorator\Ingredients\SaladIngredient;
use Otus\Task14\Decorator\Ingredients\SauceIngredient;
use Otus\Task14\Decorator\Ingredients\SausageIngredient;
use Otus\Task14\Strategy\OrderStrategy;
use Otus\Task14\Strategy\Strategies\CustomIngredientsStrategy;


include __DIR__ . '/../vendor/autoload.php';


enum ProductEnum{
    case HotDog;
}

class Client{
    public function __invoke(): void
    {
        $order = new OrderStrategy(
            ProductEnum::HotDog,
            new CustomIngredientsStrategy(new BunIngredient(new SausageIngredient(new SaladIngredient(new SauceIngredient()))))
        );

        $order->make();
        $order->getTotalCalories();
    }
}




