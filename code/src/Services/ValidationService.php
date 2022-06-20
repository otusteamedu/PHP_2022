<?php

namespace Anosovm\HW5\Services;

use Anosovm\HW5\Dtos\EmailValidateDto;

class ValidationService
{
    public function __construct(
        private string $email = ''
    ) {
        $this->email = $_GET['email'];
    }

    public function validateEmail(): array
    {
        $dto = new EmailValidateDto();

        if (!$this->email) return $dto->toArray();

        $dto->email = $this->email;

        if ($this->notEmail() || $this->noMxRecord()) {
            $dto->check = 'Некорректный email';
        } else {
            $dto->check = 'Корректный email';
        }

        return $dto->toArray();
    }

    private function notEmail(): bool
    {
        preg_match('([a-zA-Z0-9._+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)', $this->email, $matches);
        return empty($matches);
    }

    private function noMxRecord(): bool
    {
        if (!$mail = strrchr($this->email, "@")) {
            return false;
        }

        $domain = substr($mail, 1);

        $res = getmxrr($domain, $mx_records, $mx_weight);

        return false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"));
    }


}