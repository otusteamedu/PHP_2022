<?php

declare(strict_types=1);

namespace App\Application\Strategy;

use App\Application\Strategy\Contract\StrategyInterface;
use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Infractructure\Request\ClientRequest;
use App\Infractructure\Request\RequestInterface;
use RuntimeException;

abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * @param RequestInterface $requestIngredients
     * @param mixed $object
     * @return ProductInterface
     */
    protected function extracted(RequestInterface $requestIngredients, ProductInterface $object): ProductInterface
    {
        foreach ($requestIngredients->getIngredients() as $ingredient) {

            if (!is_string($ingredient)) {
                throw new RuntimeException('Нет такого ингридиента');
            }

            if ($requestIngredients instanceof ClientRequest) {
                $className = "App\Application\Decorator\Drink\\".$ingredient."Decorator";
            } else {
                $className = "App\Application\Decorator\FastFood\\".$ingredient."Decorator";
            }

            try {
                $object = new $className($object);
            } catch(RuntimeException $e) {
                echo $e->getMessage(); exit;
            }
        }

        return $object->add();
    }
}