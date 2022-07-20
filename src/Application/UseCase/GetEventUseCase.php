<?php

namespace App\Application\UseCase;

use App\Domain\Contract\EventRepositoryInterface;
use App\Domain\Contract\GetEventDTOInterface;

class GetEventUseCase
{
    public function __construct(
      private EventRepositoryInterface $repository
    ) {}


    public function getEvent(GetEventDTOInterface $dto): ?array
    {
        $event = $this->repository->findByParams($dto);

        if (!$event) {
            return null;
        }

        return $event->toArray();
    }
}
