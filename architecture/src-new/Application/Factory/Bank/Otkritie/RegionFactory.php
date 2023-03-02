<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\AddressNormalized;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Region;

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
