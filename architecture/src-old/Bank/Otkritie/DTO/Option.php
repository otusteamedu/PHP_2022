<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO;

class Option
{
    public OptionName $Name;

    public int|string $Value;

    public function __construct(OptionName $Name, int|string $Value)
    {
        $this->Name = $Name;
        $this->Value = $Value;
    }
}
