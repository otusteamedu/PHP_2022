<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class Sport extends AbstractEvent
{
    public function __construct(string $title, array $body)
    {
        parent::__construct($title, $body);
    }
}
