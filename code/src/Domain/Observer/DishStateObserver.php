<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Observer;

use Cookapp\Php\Domain\Model\AbstractDish;

/**
 * Dish state observer
 */
interface DishStateObserver
{
    /**
     * @param AbstractDish $dish
     * @return void
     */
    public function update(AbstractDish $dish): void;
}
