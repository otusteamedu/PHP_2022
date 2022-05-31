<?php

declare(strict_types=1);

namespace App\Application\Strategy;

use App\Application\AbstractFactory\Factory\FastFoodFactory;
use App\Application\Strategy\Contract\StrategyInterface;
use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Infractructure\Request\RequestInterface;

/**
 *  FastFoodStrategy
 */
class FastFoodStrategy extends AbstractStrategy implements StrategyInterface
{
    private FastFoodFactory $factory;

    public function __construct()
    {
        $this->factory = new FastFoodFactory();
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public function makeBurger(RequestInterface $requestIngredients): ProductInterface
    {
        $object =  $this->factory->createBurger();

        return $this->extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public function makeHotDog(RequestInterface $requestIngredients): ProductInterface
    {
        $object =  $this->factory->createHotDog();

        return $this->extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public function makeSandwich(RequestInterface $requestIngredients): ProductInterface
    {
        $object = $this->factory->createSandwich();

        return $this->extracted($requestIngredients, $object);
    }
}