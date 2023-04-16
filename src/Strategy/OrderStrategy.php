<?php

namespace Otus\Task14\Strategy;

use Otus\Task14\ProductEnum;
use Otus\Task14\Composite\IngredientDish;
use Otus\Task14\Composite\ProductDish;
use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Factory\Contract\ProductInterface;
use Otus\Task14\Factory\HotDogProductFactory;
use Otus\Task14\Iterator\TotalCalories;
use Otus\Task14\Observer\Contract\ObserverInterface;
use Otus\Task14\Observer\ProductCooking;
use Otus\Task14\Proxy\PostEvent;
use Otus\Task14\Proxy\PostEventProxy;
use Otus\Task14\Strategy\Contract\OrderStrategyInterface;

class OrderStrategy implements ObserverInterface
{
    private OrderStrategyInterface $strategy;
    private ProductInterface $product;
    private IngredientInterface $ingredients;

    public function __construct(ProductEnum $product, OrderStrategyInterface $strategy)
    {
        $this->strategy = $strategy;

        $this->product = (match ($product) {
            ProductEnum::HotDog => new HotDogProductFactory(),
        })->make();

        $this->ingredients = $this->strategy->ingredients($product);

    }


    public function make(): void
    {
        $productCooking = new ProductCooking();
        $productCooking->registerObserver($this);

        $dish = new ProductDish($this->product);
        $dish->add(new IngredientDish($this->ingredients));
        $dish->collectTogether();

        (new PostEventProxy(new PostEvent($this->product)))->getProductStandard();

        $productCooking->cooking();

    }

    public function getTotalCalories(): void
    {
        (new TotalCalories($this->ingredients))->get();
    }

    public function notify(): void
    {
        echo 'Moй ' . $this->product->getName() . ' готов. Спасибо!' . PHP_EOL;
    }
}