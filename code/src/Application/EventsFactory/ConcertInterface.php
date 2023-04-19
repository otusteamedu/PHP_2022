<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

interface ConcertInterface
{
    public function getDatetime(): \DateTime;
}