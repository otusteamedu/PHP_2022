<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Dto\Input;

use DateTime;

class ReportFormDto
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