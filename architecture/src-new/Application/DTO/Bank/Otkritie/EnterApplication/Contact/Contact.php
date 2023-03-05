<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Contact;

class Contact
{
    // возможные значения для $Type
    public const TYPE_PHONE = 'T_Phone';
    public const TYPE_EMAIL = 'T_Email';

    // возможные значения для $contactType
    /** Телефон супруга/супруги */
    public const CONTACT_TYPE_SPOUSE = '100000000';
    /** Домашний */
    public const CONTACT_TYPE_HOME = '100000001';
    /** Рабочий */
    public const CONTACT_TYPE_WORKING = '100000002';
    /** Мобильный */
    public const CONTACT_TYPE_MOBILE = '100000003';
    /** Телефон родственников/знакомых */
    public const CONTACT_TYPE_RELATIVES = '100000004';
    /** Данные контактного лица */
    public const CONTACT_TYPE_CONTACT_PERSON = '100000005';
    /** Иной */
    public const CONTACT_TYPE_OTHER = '100000006';

    /**
     * Значение из справочника (см. константы TYPE_...).
     */
    public string $Type;

    /**
     * Значение из справочника (см. константы CONTACT_TYPE_...).
     */
    public string $contactType;

    /**
     * Номер телефона или email.
     */
    public string $Number;
    /**
     * Адрес электронной почты
     */
    public string $Address;

    public function __construct(string $Type, string $contactType, ?string $Number = null, ?string $Address = null)
    {
        $this->Type = $Type;
        $this->contactType = $contactType;
        if (!is_null($Number)) {
            $this->Number = $Number;
        }
        if (!is_null($Address)) {
            $this->Address = $Address;
        }
    }
}
