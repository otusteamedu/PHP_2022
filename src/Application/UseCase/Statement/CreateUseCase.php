<?php

namespace App\Application\UseCase\Statement;

use App\Application\Contract\StatementRepositoryInterface;
use App\Domain\Entity\Statement;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class CreateUseCase
{
    public function __construct(
        private readonly StatementRepositoryInterface $repository,
        private readonly ProducerInterface $producer
    ) {}


    public function create(): Statement
    {
        $statement = new Statement;
        $this->repository->add($statement, true);

        $this->producer->publish($statement->toAMPQMessage());

        return $statement;
    }
}
