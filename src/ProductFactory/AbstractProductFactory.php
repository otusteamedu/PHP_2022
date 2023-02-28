<?php

namespace App\ProductFactory;

use App\Listener\EventManager;
use App\Product\Product;
use App\Product\ProductInterface;
use App\Product\ProductProxy;
use App\Strategy\NullStrategy;
use App\Strategy\StrategyInterface;

abstract class AbstractProductFactory implements ProductFactoryInterface
{
    protected array $availableStrategies = [];

    private EventManager $eventManager;

    private StrategyInterface $strategy;

    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
        $strategy = new NullStrategy();
        $this->setStrategy($strategy);
    }


    public function setStrategy(StrategyInterface $strategy): self
    {
        $this->strategy = $strategy;
        return $this;
    }


    public function getStrategy(): StrategyInterface
    {
        return $this->strategy;
    }


    public function makeProduct(): ProductInterface
    {
        $this->checkStrategy();

        $product = new Product();
        $proxy = new ProductProxy($product);

        $this->eventManager->event('started', $proxy);

        $this->getStrategy()->make($product);
        $this->customActions($product);

        $this->eventManager->event('ready', $proxy);

        return $proxy;
    }


    private function checkStrategy()
    {
        if (!in_array($this->strategy::class, $this->availableStrategies, true)) {
            throw new \Exception('Strategy is not available for this factory');
        }
    }


    protected function customActions(Product $product): void
    {
        // для наследников, если им необходимо что-то сделать дополнительное с продуктом
        // паттерн шаблон
    }
}
