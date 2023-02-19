<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Список адресов.
 */
class AddressList
{
    /**
     * @var Address[]
     */
    public array $Address;

    /**
     * @param Address[] $Address
     */
    public function __construct(array $Address)
    {
        $this->Address = $Address;
    }
}
