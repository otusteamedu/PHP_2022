<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

class AgreementList
{
    public Agreement $Agreement;

    public function __construct(Agreement $Agreement)
    {
        $this->Agreement = $Agreement;
    }
}
