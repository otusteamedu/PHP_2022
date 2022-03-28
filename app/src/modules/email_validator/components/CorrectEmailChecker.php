<?php

namespace nka\otus\modules\email_validator\components;

class CorrectEmailChecker
{
    public function check($email): bool
    {
        return $this->checkString($email) && $this->checkMxDns($email);
    }

    private function checkString($email): mixed
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function checkMxDns($email): bool
    {
        $parsedEmail = explode('@', $email);
        $host = array_pop($parsedEmail);
        return checkdnsrr($host);
    }
}
