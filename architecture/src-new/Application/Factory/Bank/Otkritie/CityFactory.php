<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\AddressNormalized;
use new\Application\DTO\Bank\Otkritie\EnterApplication\Address\City;

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
