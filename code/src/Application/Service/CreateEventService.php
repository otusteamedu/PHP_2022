<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Application\Contract\EventClientInterface;
use Nikolai\Php\Application\Dto\CreateEventRequest;
use Nikolai\Php\Application\Dto\CreateEventResponse;

class CreateEventService
{
    public function __construct(private EventClientInterface $eventClient) {}

    public function createEvent(CreateEventRequest $createEventRequest): CreateEventResponse
    {
        return $this->eventClient->create($createEventRequest);
    }
}