<?php

namespace App\Application\UseCase\Bank\Otkritie;

use App\Application\Exception\InvalidValueException;
use App\Application\UseCase\Bank\DealStateMapperInterface;
use new\Domain\Enum\Bank\Common\Enum\BankApplicationStateInterface;
use new\Domain\Enum\Bank\Otkritie\OtkritieApplicationState;
use new\Domain\Enum\NewLK\DealState;

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
            OtkritieApplicationState::CLIENT_REFUSED->value => DealState::CLIENT_REFUSED,
            OtkritieApplicationState::PREAPPROVAL->value => DealState::SENT,
            OtkritieApplicationState::PLEDGE_APPROVAL->value => DealState::APPROVED,
            OtkritieApplicationState::SIGNING_OF_DOCUMENTS->value => DealState::APPROVED,
            OtkritieApplicationState::LOAN_HAS_BEEN_ISSUED->value => DealState::FINANCED,
            default => throw new InvalidValueException('Передано некорректное значение OtkritieApplicationState'),
        };
    }
}
