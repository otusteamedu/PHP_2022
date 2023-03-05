<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\AddressList;
use App\Bank\Otkritie\DTO\EnterApplication\BoolStringValue;
use App\Bank\Otkritie\DTO\EnterApplication\Name;
use App\Bank\Otkritie\DTO\EnterApplication\NameList;
use App\Bank\Otkritie\DTO\EnterApplication\PartyInfo;
use App\Bank\Otkritie\DTO\EnterApplication\WorkInfo;
use App\Bank\Otkritie\DTO\EnterApplication\WorkPlace;
use App\Exception\InvalidValueException;
use Dvizh\BankBusDTO\NewBusCompany;
use Dvizh\BankBusDTO\NewBusPerson;
use Dvizh\BankBusDTO\NewBusPersonRole;
use Dvizh\BankBusDTO\NewBusYesNo;

class WorkPlaceFactory
{
    public static function createByNewBusCompany(NewBusCompany $company, bool $isMainCompany = false): WorkPlace
    {
        $workInfo = WorkInfoFactory::createByNewBusCompany($company, $isMainCompany);

        $partyInfo = PartyInfoFactory::createByNewBusCompany($company);

        return new WorkPlace($workInfo, $partyInfo);
    }

    public static function createForSelfEmployer(NewBusPerson $person): WorkPlace
    {
        if (\is_null($person->inn) && self::isInnRequired($person)) {
            throw new InvalidValueException('Поля ИНН физ.лица должно быть обязательно заполнено для самозанятого');
        }
        $workInfo = new WorkInfo(BoolStringValue::TRUE, 'Самозанятый');

        $name = new Name($person->name->toString());
        $nameList = new NameList([$name]);
        $address = AddressFactory::createWorkingAddressByAddressNormalized($person->registeredPlace->addressNormalized);
        $addressList = new AddressList([$address]);
        $partyInfo = new PartyInfo(
            $nameList,
            $person->inn ?? '',
            $addressList,
            PartyInfo::INDUSTRY_OTHER,
            PartyInfo::NUMBER_OF_EMPLOYEE_LESS_THAN_50
        );

        return new WorkPlace($workInfo, $partyInfo);
    }

    private static function isInnRequired(NewBusPerson $person): bool
    {
        if (
            $person->role->extract() === NewBusPersonRole::BORROWER
            || (
                $person->role->extract() === NewBusPersonRole::COBORROWER
                && !\is_null($person->isFinancialContribution)
                && $person->isFinancialContribution->extract() === NewBusYesNo::YES
            )
        ) {
            return true;
        }
        return false;
    }
}
