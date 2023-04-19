<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class ConcertExhibition extends AbstractEvent implements ConcertInterface
{
    private array $container;

    public function getDatetime(): \DateTime
    {
        return $this->getBody()['datetime'];
    }

    public function add(ConcertInterface $concert): void
    {
        $this->container[] = $concert;
    }
}
