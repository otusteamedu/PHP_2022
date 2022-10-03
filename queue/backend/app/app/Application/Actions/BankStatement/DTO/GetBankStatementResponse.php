<?php

namespace App\Application\Actions\BankStatement\DTO;

class GetBankStatementResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
