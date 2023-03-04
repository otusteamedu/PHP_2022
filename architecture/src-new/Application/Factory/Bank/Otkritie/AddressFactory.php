<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\AddressNormalized;
use Dvizh\BankBusDTO\RegisteredPlace;
use new\Application\DTO\Bank\Otkritie\EnterApplication\Address\Address;
use new\Application\DTO\Bank\Otkritie\EnterApplication\Address\ClassCodes;

class AddressFactory
{
    public static function createWorkingAddressByAddressNormalized(AddressNormalized $addressNormalized): Address
    {
        $address = new Address(Address::TYPE_WORKING_ADDRESS, $addressNormalized->looselyTypedAddress);

        $country = CountryFactory::createByNewBusCountry($addressNormalized->country);
        if (!is_null($country)) {
            $address->Country = $country;
        }

        $region = RegionFactory::createByAddressNormalized($addressNormalized);
        if (!is_null($region)) {
            $address->Region = $region;
        }

        $city = CityFactory::createByAddressNormalized($addressNormalized);
        if (!is_null($city)) {
            $address->City = $city;
        }

        return $address;
    }

    public static function createByRegisteredPlace(RegisteredPlace $registeredPlace): Address
    {
        $address = new Address(Address::TYPE_PERMANENT_REGISTRATION, $registeredPlace->address);

        $address->ZIP = $registeredPlace->addressNormalized->zip;

        $country = CountryFactory::createByNewBusCountry($registeredPlace->addressNormalized->country);
        if (!is_null($country)) {
            $address->Country = $country;
        }

        $region = RegionFactory::createByAddressNormalized($registeredPlace->addressNormalized);
        if (!is_null($region)) {
            $address->Region = $region;
        }

        $city = CityFactory::createByAddressNormalized($registeredPlace->addressNormalized);
        if (!is_null($city)) {
            $address->City = $city;
        }

        $street = StreetFactory::createByAddressNormalized($registeredPlace->addressNormalized);
        if (!is_null($street)) {
            $address->Street = $street;
        }
        $address->House = $registeredPlace->addressNormalized->house;
        $address->Apartment = $registeredPlace->addressNormalized->flat;

        //todo нужно откуда-то брать кладр, пока отправляем фейковый
        $classCodes = new ClassCodes();
        $classCodes->Addr_KLADR = '6400000100000';
        $address->ClassCodes = $classCodes;

        return $address;
    }

    public static function createByResidenceAddress(string $fullAddress, AddressNormalized $addressNormalized): Address
    {
        $address = new Address(Address::TYPE_ACTUAL_ACCOMMODATION, $fullAddress);

        $address->ZIP = $addressNormalized->zip;

        $country = CountryFactory::createByNewBusCountry($addressNormalized->country);
        if (!is_null($country)) {
            $address->Country = $country;
        }

        $region = RegionFactory::createByAddressNormalized($addressNormalized);
        if (!is_null($region)) {
            $address->Region = $region;
        }

        $city = CityFactory::createByAddressNormalized($addressNormalized);
        if (!is_null($city)) {
            $address->City = $city;
        }

        $street = StreetFactory::createByAddressNormalized($addressNormalized);
        if (!is_null($street)) {
            $address->Street = $street;
        }
        $address->House = $addressNormalized->house;
        $address->Apartment = $addressNormalized->flat;

        return $address;
    }
}
