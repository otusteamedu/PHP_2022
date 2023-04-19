<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

interface EventFactoryInterface
{
    public function make(string $title, array $body): AbstractEvent;
}