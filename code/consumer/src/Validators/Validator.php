<?php

namespace Ppro\Hw27\Consumer\Validators;

use Ppro\Hw27\Consumer\Entity\DtoInterface;

abstract class Validator
{
    protected $errors = [];

    public function validateName(string $value)
    {
        if(mb_strlen($value) < 2) {
            $this->errors[] = 'Name invalid value';
        }
    }

    public function validateEmail(string $value)
    {
        if(
          !filter_var($value, FILTER_VALIDATE_EMAIL)
        ) {
            $this->errors[] = 'Email invalid value';
        }
    }

    public function validatePastDate(string $value)
    {
        $formDate = strtotime($value);

        if($formDate > time())
            $this->errors[] = 'Date invalid value';
    }
    abstract public function validate(DtoInterface $dto): array;
}