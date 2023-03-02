<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

class Address
{
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
