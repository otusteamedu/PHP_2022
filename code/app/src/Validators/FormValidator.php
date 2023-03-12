<?php

namespace Ppro\Hw27\App\Validators;

use Ppro\Hw27\App\Entity\DtoInterface;

class FormValidator extends Validator
{
    public function validate(DtoInterface $dto): array
    {
        $this->validateName($dto->name);
        $this->validateEmail($dto->email);
        $this->validatePastDate($dto->date);
        return $this->errors;
    }
}