<?php

namespace App\Http\Contracts;

interface FetchBankStatementForClientRequestInterface
{
    public function getId(): string;

    public function getSecretToken(): string;
}
