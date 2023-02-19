<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

class AgreementList
{
    /**
     * @var Agreement[]
     */
    public array $Agreement;

    /**
     * @param Agreement[] $Agreement
     */
    public function __construct(array $Agreement)
    {
        $this->Agreement = $Agreement;
    }
}
