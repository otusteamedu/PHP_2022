<?php

declare(strict_types=1);

namespace App\App\Service;

use App\App\Payment\DTO\ChargeRequest;

class ChargeRequestValidator
{
    public function isValid(ChargeRequest $request): bool
    {
        return false;
        // TODO ...
    }
}