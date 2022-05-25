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
class FastFoodStrategy implements StrategyInterface
{
    use StrategyTrait;

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public static function makeBurger(RequestInterface $requestIngredients): ProductInterface
    {
        $object = FastFoodFactory::createBurger();

        return self::extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public static function makeHotDog(RequestInterface $requestIngredients): ProductInterface
    {
        $object = FastFoodFactory::createHotDog();

        return self::extracted($requestIngredients, $object);
    }

    /**
     * @param RequestInterface $requestIngredients
     * @return ProductInterface
     */
    public static function makeSandwich(RequestInterface $requestIngredients): ProductInterface
    {
        $object = FastFoodFactory::createSandwich();

        return self::extracted($requestIngredients, $object);
    }
}