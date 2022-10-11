<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Application\Contract\EventClientInterface;
use Nikolai\Php\Application\Dto\FindEventRequest;
use Nikolai\Php\Application\Dto\FindEventResponse;

class FindEventService
{
    public function __construct(private EventClientInterface $eventClient) {}

    public function findEvent(FindEventRequest $findEventRequest): FindEventResponse
    {
        return $this->eventClient->find($findEventRequest);
    }
}