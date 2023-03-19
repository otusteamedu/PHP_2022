<?php

namespace Ppro\Hw20\Actions;

use Ppro\Hw20\Exceptions\KitchenException;
use Ppro\Hw20\Products\ProductInterface;

/** Проверяем наличие ингредиентов на складе
 *
 */
class Prepare extends CookAction
{
    public function handle(ProductInterface $product): void
    {
        $this->checkIngredientsAvailability($this->ingredient);
        parent::handle($product);
    }

    private function checkIngredientsAvailability(array $ingredients)
    {
        //... проверка наличия ингредиентов
        $available = true;
        if(!$available)
            throw new KitchenException("Ingredient does not exist");
    }
}