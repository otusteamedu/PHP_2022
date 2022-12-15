<?php

declare(strict_types=1);

namespace App\Application\Dto\Input;

use DateTime;

class AccountStatementFormDto
{
    public string $name;

    public DateTime $dateBeginning;

    public DateTime $dateEnding;

    public function __construct(array $data = [])
    {
        $this->name = $data['name'] ?? '';
        $this->dateBeginning = $data['dateBeginning'] ?? new DateTime();
        $this->dateEnding = $data['dateEnding'] ?? new DateTime();
    }
}