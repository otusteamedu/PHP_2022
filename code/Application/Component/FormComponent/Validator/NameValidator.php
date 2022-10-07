<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator;

use RuntimeException;

class NameValidator implements ValidatorInterface
{
    public function validate(string $data): void
    {
        if (!preg_match('/[А-яёЁ$]/u', $data)) {
            throw new RuntimeException('Cyrillic alphabets required.');
        }
    }
}