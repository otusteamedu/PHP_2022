<?php

declare(strict_types=1);

namespace Src\Services\Modules\Contracts;

interface Validator
{
    public function validate(string $email): string;
}
