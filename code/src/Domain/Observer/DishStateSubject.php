<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Observer;

/**
 * Dish state subject
 */
interface DishStateSubject
{
    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function attach(DishStateObserver $observer): void;

    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function detach(DishStateObserver $observer): void;

    /**
     * @return void
     */
    public function notify(): void;
}
