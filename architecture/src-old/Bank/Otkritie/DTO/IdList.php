<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO;

class IdList
{
    /**
     * @var Id[]
     */
    public array $Id;

    /**
     * @param Id[] $Id
     */
    public function __construct(array $Id)
    {
        $this->Id = $Id;
    }
}
