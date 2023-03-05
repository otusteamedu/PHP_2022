<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO;

class OptionList
{
    /**
     * @var Option[]
     */
    public array $Option;

    /**
     * @param Option[] $Option
     */
    public function __construct(array $Option)
    {
        $this->Option = $Option;
    }
}
