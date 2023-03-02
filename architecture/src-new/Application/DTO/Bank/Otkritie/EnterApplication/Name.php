<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

class Name
{
    public string $Name;

    public function __construct(string $Name)
    {
        $this->Name = $Name;
    }
}
