<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\Types\Country as NewBusCountry;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Country;

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
