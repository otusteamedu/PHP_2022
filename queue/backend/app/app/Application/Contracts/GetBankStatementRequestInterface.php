<?php

namespace App\Application\Contracts;

use App\Models\User;

interface GetBankStatementRequestInterface
{
    public function getUser(): User;

    public function getTransferChannel(): string;
}
