<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Observer;

use SplObserver;
use SplSubject;

class SandwichObserver implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        fwrite(STDOUT, 'Наблюдатель: SandwichObserver, Состояние: ' . $subject->getStringState() . PHP_EOL);
    }
}