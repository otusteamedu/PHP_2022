<?php

namespace App\Application\Contract;

use App\Domain\Entity\Statement;

interface StatementRepositoryInterface
{

    public function add(Statement $entity, bool $flush = false): void;

    public function remove(Statement $entity, bool $flush = false): void;

    public function findOneById(string $value): ?Statement;

}
