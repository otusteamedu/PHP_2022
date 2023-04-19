<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class SportFactory implements EventFactoryInterface
{
    public function make(string $title, array $body): Sport
    {
        return new Sport($title, $body);
    }
}
