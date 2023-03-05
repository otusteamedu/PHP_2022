<?php

namespace App\Application\UseCase\Bank;

use App\Application\Exception\InvalidValueException;
use App\Domain\Entity\Bank;
use App\Domain\Entity\Deal;
use App\Application\UseCase\Bank\Otkritie as OtkritieDealStateMapper;

class DealStateMapperResolver
{
    public static function getMapperByBank(Bank $bank, Deal $deal): DealStateMapperInterface
    {
        return match ($bank->getInternalId()->toString()) {
            // ... другие банки
            Bank::UUID_OTKRITIE => new OtkritieDealStateMapper(),
            default => throw new InvalidValueException('Для банка ' . $bank->getInternalId() . ' нет DealStateMapper')
        };
    }
}
