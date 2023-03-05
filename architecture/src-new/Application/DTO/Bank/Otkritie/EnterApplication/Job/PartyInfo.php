<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Job;

use App\Application\DTO\Bank\Otkritie\EnterApplication\Address\AddressList;
use App\Application\DTO\Bank\Otkritie\EnterApplication\NameList;
use new\Application\DTO\Bank\Otkritie\EnterApplication\Contact\ContactList;

class PartyInfo
{
    /**
     * ИНН.
     */
    public string $INN;

    /**
     * Список адресов компании.
     */
    public AddressList $AddressList;

    /**
     * Список контактов компании.
     */
    public ?ContactList $ContactList;

    /**
     * Наименования организации.
     */
    public NameList $NameList;

    /**
     * Организационно-правовая форма.
     */
    public ?string $OrgType;

    /**
     * Сфера деятельности организации.
     */
    public int $Industry;

    public ?int $NumberOfEmployee;

    public function __construct(
        NameList $NameList,
        string $INN,
        AddressList $AddressList,
        int $Industry,
        int $NumberOfEmployee
    ) {
        $this->INN = $INN;
        $this->AddressList = $AddressList;
        $this->NameList = $NameList;
        $this->Industry = $Industry;
        $this->NumberOfEmployee = $NumberOfEmployee;
    }
}
