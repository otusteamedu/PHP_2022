<?php

namespace Ppro\Hw27\Consumer\Validators;

use Ppro\Hw27\Consumer\Entity\DtoInterface;

class MailValidator extends Validator
{
    public function validate(DtoInterface $dto): array
    {
        $this->validateEmail($dto->email);
        return $this->errors;
    }
}