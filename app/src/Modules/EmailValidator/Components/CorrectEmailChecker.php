<?php

namespace Nka\Otus\Modules\EmailValidator\Components;

use Nka\Otus\Components\Checker\CheckerInterface;

class CorrectEmailChecker implements CheckerInterface
{
    public function check(string $string): bool
    {
        return $this->checkString($string) && $this->checkMxDns($string);
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
