<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Observer;

use SplObserver;
use SplSubject;

class BurgerObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        fwrite(STDOUT, 'Наблюдатель: BurgerObserver, Состояние: ' . $subject->getStringState() . PHP_EOL);
    }
}