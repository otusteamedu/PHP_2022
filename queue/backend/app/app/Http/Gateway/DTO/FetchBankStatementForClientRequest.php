<?php

namespace App\Http\Gateway\DTO;

use App\Http\Contracts\FetchBankStatementForClientRequestInterface;

class FetchBankStatementForClientRequest
    implements FetchBankStatementForClientRequestInterface
{
    private string $id;

    private string $secretToken;

    public function __construct(string $id, string $secretToken)
    {
        $this->id = $id;
        $this->secretToken = $secretToken;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSecretToken(): string
    {
        return $this->secretToken;
    }
}
