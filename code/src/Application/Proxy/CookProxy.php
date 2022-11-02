<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Proxy;

use Nikolai\Php\Domain\Model\CookableInterface;
use Nikolai\Php\Infrastructure\Event\PostCookEvent;
use Nikolai\Php\Infrastructure\Event\PreCookEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

class CookProxy implements CookableInterface
{
    public function __construct(private CookableInterface $cook, private EventDispatcherInterface $eventDispatcher) {}

    public function cook(): void
    {
        $preCookEvent = new PreCookEvent($this->cook->getDish());
        $this->eventDispatcher->dispatch($preCookEvent);

        $this->cook->cook();

        $postCookEvent = new PostCookEvent($this->cook->getDish());
        $this->eventDispatcher->dispatch($postCookEvent);
    }
}