<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator;

interface ValidatorInterface
{
    public function validate(string $data): void;
}