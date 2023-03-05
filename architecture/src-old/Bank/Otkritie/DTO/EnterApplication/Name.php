<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class Name
{
    public string $Name;

    public function __construct(string $Name)
    {
        $this->Name = $Name;
    }
}
