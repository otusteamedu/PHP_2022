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

    public function getResult(): string
    {
        if (empty($this->errors)) {
            return '[OK] '.$this->value.PHP_EOL;
        } else {
            return '[BAD] '.$this->value.PHP_EOL.'Причины: '.implode('; ', $this->errors).PHP_EOL;
        }
    }
}
