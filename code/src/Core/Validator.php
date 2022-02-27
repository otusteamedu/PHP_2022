<?php

namespace Decole\NginxBalanceApp\Core;

class Validator
{
    public function validateEmail(?string $email): array
    {
        $validation = [
            'is_validated' => false,
            'message' => 'Email not valid!',
        ];

        if (!$email) {
            return $validation;
        }

        if ($this->validate($email)) {
            $validation['is_validated'] = true;
            $validation['message'] = 'Email validate successfully';

            return $validation;
        }

        return $validation;
    }

    private function validate(string $email):bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && $this->checkEmailMxRecord($email);
    }

    private function checkEmailMxRecord(string $email): bool
    {
        $record = 'MX';
        $domain = explode('@', $email)[1];

        return checkdnsrr($domain, $record);
    }
}