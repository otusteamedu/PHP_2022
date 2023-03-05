<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie;

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
