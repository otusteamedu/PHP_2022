<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\AddressList;
use App\Bank\Otkritie\DTO\EnterApplication\Name;
use App\Bank\Otkritie\DTO\EnterApplication\NameList;
use App\Bank\Otkritie\DTO\EnterApplication\PartyInfo;
use App\Exception\InvalidValueException;
use Dvizh\BankBusDTO\NewBusCompany;
use Dvizh\BankBusDTO\Types\CompanyIndustry;
use Dvizh\BankBusDTO\Types\CompanyNumberOfStaff;

class PartyInfoFactory
{
    public const INDUSTRY_MAPPING = [
        CompanyIndustry::RESCUE_SERVICE => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::ENGINEERING => PartyInfo::INDUSTRY_MECHANICAL_ENGINEERING,
        CompanyIndustry::VEHICLE_SERVICE => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::REALTOR => PartyInfo::INDUSTRY_REALTOR_ACTIVITY,
        CompanyIndustry::BANKS => PartyInfo::INDUSTRY_FINANCE,
        CompanyIndustry::COMMUNAL_REPAIR => PartyInfo::INDUSTRY_MUNICIPAL_AND_ROAD_SERVICES,
        CompanyIndustry::EXTRACTIVE => PartyInfo::INDUSTRY_EXTRACTIVE_INDUSTRY_AND_ENERGY_AND_METALLURGY,
        CompanyIndustry::OTHER => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::HEALTH_CARE => PartyInfo::INDUSTRY_HEALTH_AND_SOCIAL_SECURITY,
        CompanyIndustry::GAMBLING => PartyInfo::INDUSTRY_GAMBLING_AND_SHOW_BUSINESS,
        CompanyIndustry::IT => PartyInfo::INDUSTRY_INFORMATION_TECHNOLOGY,
        CompanyIndustry::HR => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::CONSULTING => PartyInfo::INDUSTRY_FINANCE,
        CompanyIndustry::SHOWBIZ => PartyInfo::INDUSTRY_GAMBLING_AND_SHOW_BUSINESS,
        CompanyIndustry::FOOD_INDUSTRY => PartyInfo::INDUSTRY_LIGHT_INDUSTRY,
        CompanyIndustry::FORESTRY => PartyInfo::INDUSTRY_AGRICULTURE_AND_FORESTRY,
        CompanyIndustry::PAWNSHOP => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::METALLURGY => PartyInfo::INDUSTRY_EXTRACTIVE_INDUSTRY_AND_ENERGY_AND_METALLURGY,
        CompanyIndustry::PUBLIC_ADMINISTRATION => PartyInfo::INDUSTRY_PUBLIC_SERVICE,
        CompanyIndustry::SCIENCE => PartyInfo::INDUSTRY_EDUCATION_AND_CULTURE_AND_SPORT,
        CompanyIndustry::CATERING => PartyInfo::INDUSTRY_TOURIST_AND_RESTAURANT_BUSINESS,
        CompanyIndustry::TRADE => PartyInfo::INDUSTRY_RETAIL_TRADE,
        CompanyIndustry::SECURITY => PartyInfo::INDUSTRY_PRIVATE_SECURITY_AND_DETECTIVE_COMPANIES,
        CompanyIndustry::PUBLISHING => PartyInfo::INDUSTRY_MEDIA,
        CompanyIndustry::POLITICANS => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::COURT => PartyInfo::INDUSTRY_POWER_STRUCTURES,
        CompanyIndustry::FUEL_AND_ENERGY => PartyInfo::INDUSTRY_EXTRACTIVE_INDUSTRY_AND_ENERGY_AND_METALLURGY,
        CompanyIndustry::RADIOELECTRONIC => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::DESIGN => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::MANUFACTURING => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::PR => PartyInfo::INDUSTRY_MARKETING,
        CompanyIndustry::BEAUTY_SALON => PartyInfo::INDUSTRY_HEALTH_AND_SOCIAL_SECURITY,
        CompanyIndustry::COMMUNICATION => PartyInfo::INDUSTRY_INFORMATION_TECHNOLOGY,
        CompanyIndustry::AGRICULTURE => PartyInfo::INDUSTRY_AGRICULTURE_AND_FORESTRY,
        CompanyIndustry::ARMED_FORCES => PartyInfo::INDUSTRY_POWER_STRUCTURES,
        CompanyIndustry::MASS_MEDIA => PartyInfo::INDUSTRY_MEDIA,
        CompanyIndustry::SOCIAL_SERVICES => PartyInfo::INDUSTRY_HEALTH_AND_SOCIAL_SECURITY,
        CompanyIndustry::BUILDING => PartyInfo::INDUSTRY_BUILDING_MATERIALS,
        CompanyIndustry::TAX_POLICE => PartyInfo::INDUSTRY_PUBLIC_SERVICE,
        CompanyIndustry::TOURISM => PartyInfo::INDUSTRY_TOURIST_AND_RESTAURANT_BUSINESS,
        CompanyIndustry::HPU => PartyInfo::INDUSTRY_MUNICIPAL_AND_ROAD_SERVICES,
        CompanyIndustry::CHEMICAL_INDUSTRY => PartyInfo::INDUSTRY_CHEMICAL_INDUSTRY,
        CompanyIndustry::JEWELRY => PartyInfo::INDUSTRY_OTHER,
        CompanyIndustry::LEGAL_SERVICE => PartyInfo::INDUSTRY_LEGAL_SERVICES,
    ];

    public const NUMBER_OF_EMPLOYEE_MAPPING = [
        CompanyNumberOfStaff::LESS_THAN_10 => PartyInfo::NUMBER_OF_EMPLOYEE_LESS_THAN_50,
        CompanyNumberOfStaff::BETWEEN_10_AND_50 => PartyInfo::NUMBER_OF_EMPLOYEE_LESS_THAN_50,
        CompanyNumberOfStaff::BETWEEN_50_AND_100 => PartyInfo::NUMBER_OF_EMPLOYEE_FROM_51_TILL_100,
        CompanyNumberOfStaff::BETWEEN_100_AND_500 => PartyInfo::NUMBER_OF_EMPLOYEE_FROM_101_TILL_250,
        CompanyNumberOfStaff::BETWEEN_500_AND_1000 => PartyInfo::NUMBER_OF_EMPLOYEE_MORE_THAN_251,
        CompanyNumberOfStaff::MORE_THAN_1000 => PartyInfo::NUMBER_OF_EMPLOYEE_MORE_THAN_251,
    ];

    public static function createByNewBusCompany(NewBusCompany $company): PartyInfo
    {
        if (is_null($company->name) || is_null($company->inn) || is_null($company->addressNormalized)) {
            throw new InvalidValueException('Наименование, ИНН и адрес компании должны быть заполнены!');
        }
        $name = new Name($company->name);
        $nameList = new NameList([$name]);

        $industryType = self::INDUSTRY_MAPPING[$company->industry->value] ?? null;
        if (is_null($industryType)) {
            throw new InvalidValueException(sprintf('Invalid value for IndustryType: %s', strval($company->industry->value)));
        }

        $numberOfEmployee = self::NUMBER_OF_EMPLOYEE_MAPPING[$company->numberOfStaff->value] ?? null;
        if (is_null($numberOfEmployee)) {
            throw new InvalidValueException(sprintf('Invalid value for NumberOfEmployee: %s', strval($company->numberOfStaff->value)));
        }

        $address = AddressFactory::createWorkingAddressByAddressNormalized($company->addressNormalized);
        $addressList = new AddressList([$address]);

        return new PartyInfo(
            $nameList,
            $company->inn,
            $addressList,
            $industryType,
            $numberOfEmployee
        );
    }
}
