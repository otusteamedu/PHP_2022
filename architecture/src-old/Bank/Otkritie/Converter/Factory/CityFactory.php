<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\City;
use Dvizh\BankBusDTO\AddressNormalized;

class CityFactory
{
    public static function createByAddressNormalized(AddressNormalized $addressNormalized): ?City
    {
        if (is_null($addressNormalized->city)) {
            return null;
        }

        return new City($addressNormalized->city);
    }
}
