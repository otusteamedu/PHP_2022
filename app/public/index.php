<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use SGakhramanov\Patterns\Classes\Decorators\IngredientProductDecorator;
use SGakhramanov\Patterns\Classes\Strategy\MakeProductStrategy;
use SGakhramanov\Patterns\Classes\Strategy\ProductProxyStrategy;

try {
    //Стратегия
    $product = (new MakeProductStrategy())->makeProductByCalories(500);
    //Декоратор
    $productIngredientDecorator = new IngredientProductDecorator($product);
    $productIngredientDecorator->setIngredientExtra(['сыр']);
    $preparedProduct = $productIngredientDecorator->make();
    //Прокси
    $burgerProxy = (new ProductProxyStrategy())->getProxy($preparedProduct);
    $burgerProxy->check();
} catch (Exception $e) {
    echo $e->getMessage();
}
