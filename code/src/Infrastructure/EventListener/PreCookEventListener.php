<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\EventListener;

use Cookapp\Php\Infrastructure\Event\PreCookEvent;

/**
 * Pre Cook Event Listener
 */
class PreCookEventListener
{
    /**
     * @param PreCookEvent $event
     * @return void
     */
    public function __invoke(PreCookEvent $event): void
    {
        fwrite(STDOUT, 'PreCookEventListener, event: PreCookEvent' . PHP_EOL);
    }
}
