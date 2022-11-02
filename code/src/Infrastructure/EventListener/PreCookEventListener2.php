<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\EventListener;

use Nikolai\Php\Infrastructure\Event\PreCookEvent;

class PreCookEventListener2
{
    public function __invoke(PreCookEvent $event): void
    {
        fwrite(STDOUT, 'PreCookEventListener2! ' . get_class($this) . PHP_EOL);
    }
}