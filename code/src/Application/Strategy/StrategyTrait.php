<?php

namespace App\Application\Strategy;

use App\Infractructure\Request\ClientRequest;
use App\Infractructure\Request\RequestInterface;

/**
 * StrategyTrait
 */
trait StrategyTrait
{
    /**
     * @param RequestInterface $requestIngredients
     * @param mixed $object
     * @return mixed
     */
    public static function extracted(RequestInterface $requestIngredients, mixed $object): mixed
    {
        foreach ($requestIngredients->getIngredients() as $ingredient) {

            if ($requestIngredients instanceof ClientRequest) {
                $className = "App\Application\Decorator\Drink\\".$ingredient."Decorator";
            } else {
                $className = "App\Application\Decorator\FastFood\\".$ingredient."Decorator";
            }

            $object = new $className($object);
        }

        return $object->add();
    }
}