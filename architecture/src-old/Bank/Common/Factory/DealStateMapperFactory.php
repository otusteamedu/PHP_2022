<?php

namespace App\Bank\Common\Factory;

use App\Bank\Otkritie\Converter\Factory\DealStateMapper as OtkritieDealStateMapper;
use App\Entity\Bank;
use App\Entity\Deal;
use App\Exception\InvalidValueException;

class DealStateMapperFactory
{
    public static function getMapperByBank(Bank $bank, Deal $deal): DealStateMapperInterface
    {
        return match ($bank->getInternalId()->toString()) {
            Bank::UUID_OTKRITIE => new OtkritieDealStateMapper(),
            default => throw new InvalidValueException('Для банка ' . $bank->getInternalId() . ' нет DealStateMapper')
        };
    }
}
