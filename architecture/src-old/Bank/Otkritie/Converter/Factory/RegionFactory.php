<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\Region;
use Dvizh\BankBusDTO\AddressNormalized;

class RegionFactory
{
    public static function createByAddressNormalized(AddressNormalized $addressNormalized): ?Region
    {
        if (is_null($addressNormalized->region)) {
            return null;
        }

        return new Region($addressNormalized->region);
    }
}
