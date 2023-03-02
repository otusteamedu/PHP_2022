<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

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
