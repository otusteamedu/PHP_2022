<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\AddressNormalized;
use new\Application\DTO\Bank\Otkritie\EnterApplication\Address\Street;

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
