<?php

namespace App\Application\UseCase\Statement;

use App\Application\Contract\StatementRepositoryInterface;
use App\Domain\Entity\Statement;

class ReadUseCase
{
    public function __construct(
        private readonly StatementRepositoryInterface $repository,
    ) {}


    public function get(string $id): Statement
    {
        return $this->repository->findOneById($id);
    }
}
