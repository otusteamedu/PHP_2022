<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class Address
{
    /** Постоянная регистрация */
    public const TYPE_PERMANENT_REGISTRATION = 100000000;
    /** Фактическое месторасположение */
    public const TYPE_ACTUAL_LOCATION = 100000001;
    /** Юридический */
    public const TYPE_LEGAL_ADDRESS = 100000002;
    /** Временная регистрация */
    public const TYPE_TEMPORARY_REGISTRATION = 100000004;
    /** Рабочий */
    public const TYPE_WORKING_ADDRESS = 100000005;
    /** Фактическое проживание */
    public const TYPE_ACTUAL_ACCOMMODATION = 100000007;

    /**
     * Тип адреса.
     */
    public int $addrType;

    /**
     * Полный адрес
     */
    public string $StringValue;

    public ?Country $Country;

    public ?Region $Region;

    public ?District $District;

    public City $City;

    /**
     * Классификаторы (КЛАДР и ОКАТО).
     */
    public ?ClassCodes $ClassCodes;

    /**
     * Дата регистрации по адресу.
     */
    public ?\DateTimeImmutable $RegDate;

    public ?Street $Street;
    /**
     * Дом
     */
    public ?string $House;
    /**
     * Корпус
     */
    public ?string $Block;
    /**
     * Строение.
     */
    public ?string $Housing;
    /**
     * Квартира.
     */
    public ?string $Apartment;

    /**
     * Индекс
     */
    public ?string $ZIP;

    public function __construct(
        int $addrType,
        string $StringValue
    ) {
        $this->addrType = $addrType;
        $this->StringValue = $StringValue;
    }
}
