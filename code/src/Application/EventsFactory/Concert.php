<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class Concert extends AbstractEvent implements ConcertInterface
{
    public function __construct(string $title, array $body)
    {
        parent::__construct($title, $body);
    }

    public function getDatetime(): \DateTime
    {
        return $this->getBody()['datetime'];
    }
}
