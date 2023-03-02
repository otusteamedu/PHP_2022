<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie;

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
