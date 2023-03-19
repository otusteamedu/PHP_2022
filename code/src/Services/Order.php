<?php

namespace Ppro\Hw20\Services;

use Ppro\Hw20\Exceptions\AppException;
use Ppro\Hw20\Exceptions\KitchenException;

/** Выполнение заказа
 *
 */
class Order
{
    /** Приготовление позиции заказа
     * @param string $recipeClass
     * @param string $productClass
     * @param array $recipeSteps
     * @param array $orderSets
     * @return void
     */
    public function make(string $recipeClass, string $productClass, array $recipeSteps, array $orderSets = [])
    {
        try {
            $menu = new MenuBook($recipeClass,$productClass,$recipeSteps, $orderSets);

            $kitchen = new KitchenWithQualityControl($menu->getRecipe());
            $kitchen->getProduct()->subscribe(new HallDisplay());
            $kitchen->productCook();
            echo $kitchen->getProduct()->getProductObject()->getProductInfoJson().PHP_EOL;
        } catch (KitchenException|AppException $e) {
            echo $e->getMessage();
        }
    }
}