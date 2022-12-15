<?php

declare(strict_types=1);

namespace App\Domain\Contract;

use App\Domain\Entity\AccountStatement;
use Symfony\Component\Uid\Uuid;

interface AccountStatementDaoInterface
{
    public function create(AccountStatement $accountStatement): Uuid;
    public function delete(AccountStatement $accountStatement): void;
    public function update(AccountStatement $accountStatement): void;
}