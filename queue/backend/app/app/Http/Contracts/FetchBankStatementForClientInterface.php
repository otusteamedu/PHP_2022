<?php

namespace App\Http\Contracts;

use App\Http\Gateway\DTO\FetchBankStatementForClientResponse;

interface FetchBankStatementForClientInterface
{
    public function fetchBankStatementForClient(FetchBankStatementForClientRequestInterface $request): FetchBankStatementForClientResponse;
}
