<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator\Passport;

use App\Application\Component\FormComponent\Validator\ValidatorInterface;
use RuntimeException;

class NumberValidator implements ValidatorInterface
{
    public function validate(string $data): void
    {
        if (mb_strlen($data) !== 10) {
            throw new RuntimeException('The passport number must consist of 10 digits.');
        }
    }
}