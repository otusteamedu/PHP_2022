<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class ExhibitionFactory implements EventFactoryInterface
{
    public function make(string $title, array $body): Exhibition
    {
        return new Exhibition($title, $body);
    }
}
