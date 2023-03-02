<?php

namespace App\Application\UseCase\Bank;

use new\Domain\Enum\Bank\Common\Enum\BankApplicationStateInterface;
use new\Domain\Enum\NewLK\DealState;

interface DealStateMapperInterface
{
    public function getByBankApplicationState(BankApplicationStateInterface $bankState): DealState;
}
