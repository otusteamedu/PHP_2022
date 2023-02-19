<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\Country;
use Dvizh\BankBusDTO\Types\Country as NewBusCountry;

class CountryFactory
{
    public static function createByNewBusCountry(?NewBusCountry $newBusCountry): ?Country
    {
        if (is_null($newBusCountry)) {
            return null;
        }

        return new Country(
            $newBusCountry->extract(),
            $newBusCountry->fullTitle
        );
    }
}
