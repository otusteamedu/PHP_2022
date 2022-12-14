<?php

namespace App\Application\Actions\BankStatement\DTO;

use App\Application\Contracts\GetBankStatementRequestInterface;
use App\Models\User;

class GetBankStatementRequest
    implements GetBankStatementRequestInterface
{
    private string $transferChannel;

    private User $user;

    public function __construct(User $user, string $transferChannel)
    {
        $this->user = $user;
        $this->transferChannel = $transferChannel;
    }

    public function getTransferChannel(): string
    {
        return $this->transferChannel;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
