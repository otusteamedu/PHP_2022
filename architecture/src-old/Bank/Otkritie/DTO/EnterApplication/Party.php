<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use App\Bank\Otkritie\DTO\IdList;
use App\Bank\Otkritie\DTO\OptionList;

/**
 * Участник заявки.
 */
class Party
{
    // Степени родства с заемщиком (обязательно для созаемщика, указывается в OptionList)
    /** Супруг заемщика */
    public const KINSHIP_BORROWER_HUSBAND = '100000000';
    /** Супруга заемщика */
    public const KINSHIP_BORROWER_WIFE = '100000001';
    /** Сожитель заемщика */
    public const KINSHIP_BORROWER_ROOMMATE = '100000002';
    /** Мать заемщика */
    public const KINSHIP_BORROWER_MOTHER = '100000003';
    /** Отец заемщика */
    public const KINSHIP_BORROWER_FATHER = '100000004';
    /** Мать созаемщика  */
    public const KINSHIP_COBORROWER_MOTHER = '100000005';
    /** Отец созаемщика */
    public const KINSHIP_COBORROWER_FATHER = '100000006';
    /** Сын заемщика */
    public const KINSHIP_BORROWER_SON = '100000007';
    /** Дочь заемщика */
    public const KINSHIP_BORROWER_DAUGHTER = '100000008';
    /** Сын созаемщика */
    public const KINSHIP_COBORROWER_SON = '100000009';
    /** Дочь созаемщика */
    public const KINSHIP_COBORROWER_DAUGHTER = '100000010';
    /** Брат заемщика */
    public const KINSHIP_BORROWER_BROTHER = '100000011';
    /** Сестра заемщика */
    public const KINSHIP_BORROWER_SISTER = '100000012';
    /** Брат созаемщика */
    public const KINSHIP_COBORROWER_BROTHER = '100000013';
    /** Сестра созаемщика */
    public const KINSHIP_COBORROWER_SISTER = '100000014';

    // Пол
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    // Виды деятельности (указывается в OptionList)
    /** Адвокат (адвокатский кабинет) */
    public const ACTIVITY_TYPE_LAWYER_OFFICE = 9;
    /** Адвокат (адвокатское бюро/коллегиях адвокатов/юридических консультация) */
    public const ACTIVITY_TYPE_LAWYER_CONSULTATIONS = 8;
    /** Арбитражный управляющий */
    public const ACTIVITY_TYPE_ARBITRATION_MANAGER = 17;
    /** Владелец/Совладелец бизнеса */
    public const ACTIVITY_TYPE_BUSINESS_OWNER = 11;
    /** Военнослужащий */
    public const ACTIVITY_TYPE_SERVICEMAN = 7;
    /** Военный пенсионер или судья */
    public const ACTIVITY_TYPE_MILITARY_PENSIONER_OR_JUDGE = 18;
    /** Зарплатный клиент */
    public const ACTIVITY_TYPE_SALARY_CLIENT = 16;
    /** Индивидуальный предприниматель */
    public const ACTIVITY_TYPE_INDIVIDUAL_ENTREPRENEUR = 12;
    /** Нотариус */
    public const ACTIVITY_TYPE_NOTARY = 10;
    /** Работник по найму */
    public const ACTIVITY_TYPE_EMPLOYEE = 6;
    /** Сотрудник Банка - минимальный список документов (подходит под условия) */
    public const ACTIVITY_TYPE_BANK_EMPLOYEE_SUITABLE = 1;
    /** Сотрудник Банка - сокращенный список документов (не подходит под условия) */
    public const ACTIVITY_TYPE_BANK_EMPLOYEE_UNSUITABLE = 13;
    /** Самозанятый */
    public const ACTIVITY_TYPE_SELFEMPLOYED = 20;

    // Категории клиентов (возможные значения для ClientType)
    /** Сотрудник банка */
    public const CLIENT_TYPE_BANK_EMPLOYEE = 2;
    /** Сотрудник холдинга */
    public const CLIENT_TYPE_HOLDING_EMPLOYEE = 3;
    /** Сторонний */
    public const CLIENT_TYPE_OTHER = 4;
    /** Зарплатный клиент */
    public const CLIENT_TYPE_SALARY_CLIENT = 7;

    // Возможные значения для MaritalStatus
    public const MARITAL_STATUS_NOT_MARRIED = 1;
    public const MARITAL_STATUS_MARRIED = 2;
    public const MARITAL_STATUS_CIVIL_MARRIAGE = 3;
    public const MARITAL_STATUS_DIVORCED = 4;
    public const MARITAL_STATUS_WIDOW = 5;

    // Возможные значения для PartyRole
    /** Заемщик */
    public const PARTY_ROLE_BORROWER = 5;
    /** Созаемщик */
    public const PARTY_ROLE_COBORROWER = 17;

    public IdList $IdList;

    public DocumentList $DocumentList;

    public Citizenship $Citizenship;

    /**
     * Обязательно для полной заявки, для короткой можно не заполнять.
     */
    public ?WorkPlaceList $WorkPlaceList;

    /**
     * Имя.
     */
    public string $Name;

    /**
     * Фамилия.
     */
    public string $Surname;

    /**
     * Отчество.
     */
    public string $FatherName;

    /**
     * Дополнительная информация.
     */
    public OptionList $OptionList;

    /**
     * Является ли финансовым созаемщиком (обязательно для созаемщика)
     */
    public bool $PartyType;

    /**
     * Категория клиента.
     */
    public ?int $ClientType;
    /**
     * Согласие клиента на ОПС, запрос в БКИ, передачу в БКИ.
     */
    public ConsentList $ConsentList;
    /**
     * Дата рождения. (формат Y-m-d)
     */
    public string $BirthDate;
    /**
     * Пол.
     */
    public int $Gender;
    /**
     * Место рождения.
     */
    public string $BirthPlace;

    public ?string $Email;
    /**
     * ИНН лица (обязательно для ИП, нотариусов и т.д.).
     */
    public ?string $INN;
    public ?string $SNILS;
    /**
     * Семейное положение.
     */
    public int $MaritalStatus;
    /**
     * Образование.
     */
    public ?EducationList $EducationList;
    /**
     * Общий трудовой стаж.(в годах)
     */
    public int $Seniority;
    /**
     * Контактная информация.
     */
    public ContactList $ContactList;
    /**
     * Данные об адресах клиента.
     */
    public ?AddressList $AddressList;
    /**
     * Роль клиента в заявке.
     */
    public int $PartyRole;
    /**
     * Информация о доходах.
     */
    public IncomeList $IncomeList;

    public function __construct(
        ?IdList $idList,
        DocumentList $DocumentList,
        ?string $Name = null,
        ?string $Surname = null,
        ?string $FatherName = null,
        ?\DateTimeImmutable $BirthDate = null,
        ?int $Gender = null,
        ?string $BirthPlace = null,
        ?int $MaritalStatus = null,
        ?EducationList $EducationList = null,
        ?int $Seniority = null,
        ?ContactList $ContactList = null,
        ?AddressList $AddressList = null,
        ?int $PartyRole = null,
        ?ConsentList $ConsentList = null,
        ?IncomeList $IncomeList = null,
        ?WorkPlaceList $WorkPlaceList = null,
        ?OptionList $OptionList = null
    ) {
        if (!is_null($idList)) {
            $this->IdList = $idList;
        }
        $this->DocumentList = $DocumentList;

        if (!is_null($WorkPlaceList)) {
            $this->WorkPlaceList = $WorkPlaceList;
        }
        if (!is_null($Name)) {
            $this->Name = $Name;
        }
        if (!is_null($Surname)) {
            $this->Surname = $Surname;
        }
        if (!is_null($FatherName)) {
            $this->FatherName = $FatherName;
        }
        if (!is_null($BirthDate)) {
            $this->BirthDate = $BirthDate->format('Y-m-d');
        }
        if (!is_null($Gender)) {
            $this->Gender = $Gender;
        }
        if (!is_null($BirthPlace)) {
            $this->BirthPlace = $BirthPlace;
        }
        if (!is_null($MaritalStatus)) {
            $this->MaritalStatus = $MaritalStatus;
        }
        if (!is_null($EducationList)) {
            $this->EducationList = $EducationList;
        }
        if (!is_null($Seniority)) {
            $this->Seniority = $Seniority;
        }
        if (!is_null($ContactList)) {
            $this->ContactList = $ContactList;
        }
        if (!is_null($AddressList)) {
            $this->AddressList = $AddressList;
        }
        if (!is_null($PartyRole)) {
            $this->PartyRole = $PartyRole;
        }
        if (!is_null($ConsentList)) {
            $this->ConsentList = $ConsentList;
        }
        if (!is_null($IncomeList)) {
            $this->IncomeList = $IncomeList;
        }
        if (!is_null($OptionList)) {
            $this->OptionList = $OptionList;
        }
        // в данный момент используем только тип "Сторонний"
        $this->ClientType = self::CLIENT_TYPE_OTHER;
    }
}
