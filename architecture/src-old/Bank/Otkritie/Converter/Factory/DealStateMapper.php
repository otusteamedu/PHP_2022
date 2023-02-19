<?php

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Common\Enum\BankApplicationStateInterface;
use App\Bank\Common\Factory\DealStateMapperInterface;
use App\Bank\Otkritie\Enum\OtkritieApplicationState;
use App\Exception\InvalidValueException;
use App\NewLK\Enum\DealState;

class DealStateMapper implements DealStateMapperInterface
{
    public function getByBankApplicationState(BankApplicationStateInterface $bankState): DealState
    {
        return match ($bankState->getStateValue()) {
            OtkritieApplicationState::SENT->value => DealState::SENT,
            OtkritieApplicationState::TECHNICAL_ERROR->value => DealState::TECHNICAL_ERROR,
            OtkritieApplicationState::REJECTED->value => DealState::REJECTED,
            OtkritieApplicationState::APPROVED->value => DealState::APPROVED,
            OtkritieApplicationState::RETURNED_FOR_REVISION->value => DealState::RETURNED_FOR_REVISION,

            // todo: Временная правка, пока банк не исправит баг с отказами клиентов
            OtkritieApplicationState::CLIENT_REFUSED->value => DealState::SENT,

            OtkritieApplicationState::PREAPPROVAL->value => DealState::SENT,
            OtkritieApplicationState::PLEDGE_APPROVAL->value => DealState::APPROVED,
            OtkritieApplicationState::SIGNING_OF_DOCUMENTS->value => DealState::APPROVED,
            OtkritieApplicationState::LOAN_HAS_BEEN_ISSUED->value => DealState::FINANCED,
            default => throw new InvalidValueException('Передано некорректное значение OtkritieApplicationState'),
        };
    }
}
