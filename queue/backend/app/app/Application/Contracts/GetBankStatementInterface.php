<?php

namespace App\Application\Contracts;

use App\Application\Actions\BankStatement\DTO\GetBankStatementResponse;

interface GetBankStatementInterface
{
    public function get(GetBankStatementRequestInterface $request): GetBankStatementResponse;
}
