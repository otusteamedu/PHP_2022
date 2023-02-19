<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Список контактов.
 */
class ContactList
{
    /**
     * @var Contact[]
     */
    public array $Contact;

    /**
     * @param Contact[] $Contact
     */
    public function __construct(array $Contact)
    {
        $this->Contact = $Contact;
    }
}
