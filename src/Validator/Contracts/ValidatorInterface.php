<?php

namespace App\Validator\Contracts;

interface ValidatorInterface
{
    public function validate(string $value): bool;
}
