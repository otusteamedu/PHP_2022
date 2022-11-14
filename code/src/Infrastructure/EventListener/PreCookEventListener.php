<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\EventListener;

use Nikolai\Php\Infrastructure\Event\PreCookEvent;

class PreCookEventListener
{
    public function __invoke(PreCookEvent $event): void
    {
        fwrite(STDOUT, 'PreCookEventListener, event: PreCookEvent' . PHP_EOL);
    }
}