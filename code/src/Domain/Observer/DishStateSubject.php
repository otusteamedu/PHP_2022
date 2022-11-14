<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Observer;

interface DishStateSubject
{
    public function attach(DishStateObserver $observer): void;
    public function detach(DishStateObserver $observer): void;
    public function notify(): void;
}