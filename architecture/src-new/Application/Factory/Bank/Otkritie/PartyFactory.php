<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use App\Domain\Entity\Deal;
use Dvizh\BankBusDTO\NewBusLoanData;
use Dvizh\BankBusDTO\NewBusPerson;
use Dvizh\BankBusDTO\NewBusPersonRole;
use Dvizh\BankBusDTO\NewBusRelationWithBorrower;
use Dvizh\BankBusDTO\Types\EmploymentStatus;
use Dvizh\BankBusDTO\Types\MaritalStatus;
use App\Application\DTO\Bank\Otkritie\EnterApplication\DocumentList;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Party;
use App\Application\DTO\Bank\Otkritie\IdList;
use App\Application\DTO\Bank\Otkritie\Option;
use App\Application\DTO\Bank\Otkritie\OptionList;
use App\Application\DTO\Bank\Otkritie\OptionName;
use App\Application\Exception\InvalidValueException;
use Dvizh\BankBusDTO\NewBusGender;

class PartyFactory
{
    private const KINSHIP_MAPPING = [
        NewBusRelationWithBorrower::SPOUSE => [
            NewBusGender::MALE => Party::KINSHIP_BORROWER_HUSBAND,
            NewBusGender::FEMALE => Party::KINSHIP_BORROWER_WIFE,
        ],
        NewBusRelationWithBorrower::PARENT => [
            NewBusGender::MALE => Party::KINSHIP_BORROWER_FATHER,
            NewBusGender::FEMALE => Party::KINSHIP_BORROWER_MOTHER,
        ],
        NewBusRelationWithBorrower::SIBLING => [
            NewBusGender::MALE => Party::KINSHIP_BORROWER_BROTHER,
            NewBusGender::FEMALE => Party::KINSHIP_BORROWER_SISTER,
        ],
        NewBusRelationWithBorrower::CIVIL_SPOUSE => [
            NewBusGender::MALE => Party::KINSHIP_BORROWER_ROOMMATE,
            NewBusGender::FEMALE => Party::KINSHIP_BORROWER_ROOMMATE,
        ],
        NewBusRelationWithBorrower::CHILD => [
            NewBusGender::MALE => Party::KINSHIP_BORROWER_SON,
            NewBusGender::FEMALE => Party::KINSHIP_BORROWER_DAUGHTER,
        ],
    ];

    private const GENDER_MAPPING = [
        NewBusGender::MALE => Party::GENDER_MALE,
        NewBusGender::FEMALE => Party::GENDER_FEMALE,
    ];

    private const MARITAL_STATUS_MAPPING = [
        MaritalStatus::MARRIED => Party::MARITAL_STATUS_MARRIED,
        MaritalStatus::NOT_MARRIED => Party::MARITAL_STATUS_MARRIED,
        MaritalStatus::CIVIL_MARRIAGE => Party::MARITAL_STATUS_CIVIL_MARRIAGE,
        MaritalStatus::DIVORCED => Party::MARITAL_STATUS_DIVORCED,
        MaritalStatus::WIDOW => Party::MARITAL_STATUS_WIDOW,
    ];

    private const ACTIVITY_STATUS_MAPPING = [
        EmploymentStatus::EMPLOYED => Party::ACTIVITY_TYPE_EMPLOYEE,
        EmploymentStatus::UNEMPLOYED => false,
        EmploymentStatus::PENSIONER => false,
        EmploymentStatus::TROOPER => Party::ACTIVITY_TYPE_SERVICEMAN,
        EmploymentStatus::EMPLOYED_PENSIONER => Party::ACTIVITY_TYPE_EMPLOYEE,
        EmploymentStatus::BUSINESS_OWNER => Party::ACTIVITY_TYPE_BUSINESS_OWNER,
        EmploymentStatus::SOLE_PROPRIETOR => Party::ACTIVITY_TYPE_INDIVIDUAL_ENTREPRENEUR,
        EmploymentStatus::SELF_EMPLOYED => Party::ACTIVITY_TYPE_SELFEMPLOYED,
    ];

    // В Открытие нужно отправлять данные только по заемщикам и созаемщикам
    private const PARTY_ROLE_MAPPING = [
        NewBusPersonRole::BORROWER => Party::PARTY_ROLE_BORROWER,
        NewBusPersonRole::COBORROWER => Party::PARTY_ROLE_COBORROWER,
        NewBusPersonRole::GUARANTOR => null,
        NewBusPersonRole::PLEDGOR => null,
    ];

    public static function createByPersonIdLIstAndDocuments(
        NewBusPerson $person,
        NewBusLoanData $loanData,
        IdList $idList,
        DocumentList $documentList,
        Deal $deal
    ): Party {
        // если отправляем сделку на доработку, то информацию о работе отправлять не нужно
        if (!is_null($deal->getExternalId())) {
            return new Party($idList, $documentList);
        }

        $workPlaceList = WorkPlaceListFactory::createByNewBusPerson($person);

        $options = [];

        // Для созаемщиков обязательно указываем степень родства
        if (NewBusPersonRole::COBORROWER === $person->role->value) {
            $kinship = self::KINSHIP_MAPPING[$person->relationWithBorrower->value][$person->gender->value] ?? null;
            if (is_null($kinship)) {
                throw new InvalidValueException(sprintf(
                    'Некорректное значение для relationWithBorrower: %s, gender: %s',
                    $person->relationWithBorrower->value ?? 'null',
                    $person->gender->value
                ));
            }

            $options[] = new Option(OptionName::BORROWER_RELATIVE_DEGREE, $kinship);
        }

        $activityStatus = self::ACTIVITY_STATUS_MAPPING[$person->employmentStatus->value] ?? null;
        if (is_null($activityStatus)) {
            throw new InvalidValueException(
                sprintf('Invalid value for employmentStatus: %s', $person->employmentStatus->value)
            );
        } elseif ($activityStatus !== false) {
            $options[] = new Option(OptionName::CLIENT_ACTIVITY_TYPE, $activityStatus);
        }

        $optionList = new OptionList($options);

        $consentList = ConsentListFactory::createByNewBusPerson($person);

        $gender = self::GENDER_MAPPING[$person->gender->value] ?? null;
        if (is_null($gender)) {
            throw new InvalidValueException(sprintf('Invalid value for gender: %s', $person->gender->value));
        }

        $maritalStatus = self::MARITAL_STATUS_MAPPING[$person->maritalStatus->value] ?? null;
        if (is_null($maritalStatus)) {
            throw new InvalidValueException(
                sprintf('Invalid value for maritalStatus: %s', $person->maritalStatus->value)
            );
        }

        $educationList = EducationListFactory::createByNewBusPerson($person);
        $contactList = ContactListFactory::createByNewBusPerson($person);
        $addressList = AddressListFactory::createByNewBusPerson($person);

        $role = self::PARTY_ROLE_MAPPING[$person->role->value] ?? null;
        if (is_null($role)) {
            throw new InvalidValueException(sprintf('Invalid value for $role: %s', $person->role->value));
        }

        if (is_null($person->overallExperience)) {
            $seniority = null;
        } else {
            // Общий трудовой стаж в Открытие нужно передавать в годах
            $seniority = intval(floor($person->overallExperience / 12));
        }

        $incomeList = IncomeListFactory::createByBorrowerAndNewBusLoanData($person, $loanData);

        $participant = new Party(
            $idList,
            $documentList,
            $person->name->firstName,
            $person->name->lastName,
            $person->name->middleName,
            $person->birthDate,
            $gender,
            $person->birthPlace,
            $maritalStatus,
            $educationList,
            $seniority,
            $contactList,
            $addressList,
            $role,
            $consentList,
            $incomeList,
            $workPlaceList,
            $optionList
        );

        if (NewBusPersonRole::COBORROWER === $person->role->value) {
            if (is_null($person->isFinancialContribution)) {
                $participant->PartyType = false;
            } else {
                $participant->PartyType = boolval($person->isFinancialContribution->value);
            }
        }
        $participant->INN = $person->inn;
        $participant->SNILS = $person->snils;

        $citizenship = CitizenshipFactory::createByNewBusPerson($person);
        if (!is_null($citizenship)) {
            $participant->Citizenship = $citizenship;
        }

        return $participant;
    }
}
