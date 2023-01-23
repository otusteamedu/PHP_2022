<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository\Interface;

use Dkozlov\Otus\Domain\Event;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\EventNotFoundException;
use Dkozlov\Otus\Repository\Dto\AddEventRequest;
use Dkozlov\Otus\Repository\Dto\GetEventRequest;

interface EventRepositoryInterface
{
    /**
     * @throws ConnectionTimeoutException
     */
    public function addEvent(AddEventRequest $request): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function clearEvents(): void;

    /**
     * @throws ConnectionTimeoutException
     * @throws EventNotFoundException
     */
    public function getEvent(GetEventRequest $request): Event;
}