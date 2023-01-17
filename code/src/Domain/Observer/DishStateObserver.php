<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Observer;

use Cookapp\Php\Domain\Model\AbstractDish;

interface DishStateObserver
{
    public function update(AbstractDish $dish): void;
}