<?php

namespace App\Bank\Common\Factory;

use App\Bank\Common\Enum\BankApplicationStateInterface;
use App\NewLK\Enum\DealState;

interface DealStateMapperInterface
{
    public function getByBankApplicationState(BankApplicationStateInterface $bankState): DealState;
}
