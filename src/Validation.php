<?php

declare(strict_types=1);

namespace Pinguk\Validator;

class Validation
{
    public bool $isValid = true;

    public array $errors = [];

    public mixed $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
