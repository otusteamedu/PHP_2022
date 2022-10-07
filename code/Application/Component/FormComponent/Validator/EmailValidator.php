<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator;

use RuntimeException;

class EmailValidator implements ValidatorInterface
{
    public function validate(string $data): void
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Something is wrong with the email.');
        }
    }
}