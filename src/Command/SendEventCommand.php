<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\EventNotFoundException;
use Dkozlov\Otus\Repository\Dto\GetEventRequest;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;

class SendEventCommand extends AbstractCommand
{
    public function __construct(
        private readonly EventRepositoryInterface $repository,
        array $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $request = new GetEventRequest($this->args);
            $event = $this->repository->getEvent($request);

            $result = "The \"{$event->getName()}\" event was executed";
        } catch (ConnectionTimeoutException $e) {
            $result = $e->getMessage();
        } catch (EventNotFoundException) {
            $result = 'Event with entered params not found';
        }

        echo $result . PHP_EOL;
    }
}