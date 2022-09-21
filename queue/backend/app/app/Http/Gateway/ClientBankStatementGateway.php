<?php

namespace App\Http\Gateway;

use App\Http\Contracts\FetchBankStatementForClientInterface;
use App\Http\Contracts\FetchBankStatementForClientRequestInterface;
use App\Http\Gateway\DTO\FetchBankStatementForClientResponse;

class ClientBankStatementGateway
    implements FetchBankStatementForClientInterface
{
    public function fetchBankStatementForClient(FetchBankStatementForClientRequestInterface $request): FetchBankStatementForClientResponse
    {
        return new FetchBankStatementForClientResponse([
            'id' => $request->getId(),
            'credit_status' => 'ok'
        ]);
    }
}
