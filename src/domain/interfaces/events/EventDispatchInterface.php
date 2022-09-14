<?php

namespace Mselyatin\Patterns\domain\interfaces\events;

interface EventDispatchInterface
{
    public function addAfterEvent(EventAfterInterface $eventAfter): self;
    public function addBeforeEvent(EventBeforeInterface $eventBefore): self;

    public function dispatchAfterEvents(): self;
    public function dispatchBeforeEvents(): self;
}