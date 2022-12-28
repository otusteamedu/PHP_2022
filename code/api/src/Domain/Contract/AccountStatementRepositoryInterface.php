<?php

declare(strict_types=1);

namespace App\Domain\Contract;

use App\Domain\Entity\AccountStatement;
use Symfony\Component\Uid\Uuid;

interface AccountStatementRepositoryInterface
{
    public function findById(Uuid $id): ?AccountStatement;
    public function findAll(): iterable;
}