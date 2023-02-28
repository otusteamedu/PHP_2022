<?php

namespace App\Application\UseCase;

use App\Domain\Contract\EventRepositoryInterface;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Model\Event;

class GetEventUseCase
{
    public function __construct(
      private EventRepositoryInterface $repository
    ) {}


    public function getEvent(GetEventDTOInterface $dto): ?Event
    {
        $event = $this->repository->findByParams($dto);

        if (!$event) {
            return null;
        }

        return $event->toArray();
    }
}
