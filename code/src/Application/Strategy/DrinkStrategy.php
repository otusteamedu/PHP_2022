<?php

declare(strict_types=1);

namespace App\Application\Strategy;

use App\Application\AbstractFactory\Factory\DrinkFactory;
use App\Application\Strategy\Contract\StrategyInterface;
use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Infractructure\Request\RequestInterface;

/**
 * DrinkStrategy
 */
class DrinkStrategy extends AbstractStrategy implements StrategyInterface
{
    private DrinkFactory $factory;

    public function __construct()
    {
        $this->factory = new DrinkFactory();
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public function makeCoffee(RequestInterface $requestIngredients): ProductInterface
    {
        $object = $this->factory->createCoffee();

        return $this->extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public function makeTea(RequestInterface $requestIngredients): ProductInterface
    {
        $object = $this->factory->createTea();

        return $this->extracted($requestIngredients, $object);
    }
}