<?php

namespace App\Validator;

interface ValidatorInterface
{
    public function validate(string $value): bool;
}
