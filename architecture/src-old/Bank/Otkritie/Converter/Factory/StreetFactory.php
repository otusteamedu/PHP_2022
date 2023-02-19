<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\Street;
use Dvizh\BankBusDTO\AddressNormalized;

class StreetFactory
{
    public static function createByAddressNormalized(AddressNormalized $addressNormalized): ?Street
    {
        if (is_null($addressNormalized->street)) {
            return null;
        }

        return new Street($addressNormalized->street);
    }
}
