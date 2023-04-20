<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class ConcertFactory implements EventFactoryInterface
{
    public function make(string $title, array $body): Concert
    {
        return new Concert($title, $body);
    }
}
