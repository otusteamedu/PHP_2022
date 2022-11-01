<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Observer;

use SplObserver;
use SplSubject;

class HotDogObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        fwrite(STDOUT, 'Наблюдатель: HotDogObserver, Состояние: ' . $subject->getStringState() . PHP_EOL);
    }
}