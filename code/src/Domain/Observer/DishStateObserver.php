<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Observer;

use Nikolai\Php\Domain\Model\AbstractDish;

interface DishStateObserver
{
    public function update(AbstractDish $dish): void;
}