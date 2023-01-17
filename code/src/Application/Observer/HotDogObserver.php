<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Observer;

use Cookapp\Php\Domain\Observer\DishStateObserver;
use Cookapp\Php\Domain\Model\AbstractDish;

class HotDogObserver implements DishStateObserver
{
    public function update(AbstractDish $dish): void
    {
        fwrite(STDOUT, 'Наблюдатель: HotDogObserver, Состояние: ' . $dish->getStringState() . PHP_EOL);
    }
}