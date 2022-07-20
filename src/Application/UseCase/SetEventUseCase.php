<?php

namespace App\Application\UseCase;

use App\Domain\Contract\EventRepositoryInterface;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Contract\SetEventDTOInterface;

class SetEventUseCase
{
    public function __construct(
      private EventRepositoryInterface $repository
    ) {}


    public function setEvent(SetEventDTOInterface $dto): array
    {
        return $this->repository->set($dto);
    }
}
