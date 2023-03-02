<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

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
