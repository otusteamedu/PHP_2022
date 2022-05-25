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
class DrinkStrategy implements StrategyInterface
{
    use StrategyTrait;

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public static function makeCoffee(RequestInterface $requestIngredients): ProductInterface
    {
        $object = DrinkFactory::createCoffee();

        return self::extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public static function makeTea(RequestInterface $requestIngredients): ProductInterface
    {
        $object = DrinkFactory::createTea();

        return self::extracted($requestIngredients, $object);
    }
}