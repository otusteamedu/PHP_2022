<?php

declare(strict_types=1);

class EmailValidator
{
    public function validate(string $email, string &$error = null): bool
    {
        $explodeEmail = \explode('@', $email);
        if (\count($explodeEmail) === 2 && $this->checkByRegex($email) && $this->checkMx($explodeEmail[1])) {
            return true;
        }
        $error = 'Incorrect email';
        return false;
    }

    private function checkByRegex(string $email): bool
    {
        return (bool)\preg_match('/.+@.+\..+/', $email);
    }

    private function checkMx(string $domain): bool
    {
        return \checkdnsrr($domain);
    }
}
