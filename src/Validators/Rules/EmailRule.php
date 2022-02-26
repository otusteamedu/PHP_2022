<?php

declare(strict_types=1);

namespace Philip\Otus\Validators\Rules;

class EmailRule implements RuleInterface
{
    private array $errors = [];

    public function make($value): bool
    {
        if (!(is_string($value))) {
            $this->errors[] = 'The email is invalid';
            return false;
        }
        $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        if (preg_match($regex, $value)) {
            return true;
        }
        $this->errors[] = 'The email is invalid';
        return false;
    }

    public function fail(): array
    {
        return $this->errors;
    }
}