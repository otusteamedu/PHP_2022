<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator\Passport;

use App\Application\Component\FormComponent\Validator\ValidatorInterface;
use RuntimeException;

class IssueCodeValidator implements ValidatorInterface
{
    public function validate(string $data): void
    {
        if (!preg_match('/^\d{3}-\d{3}$/', $data)) {
            throw new RuntimeException('Wrong passport issue code.');
        }
    }
}