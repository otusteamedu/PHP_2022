<?php

namespace Waisee\EmailValidator\Helpers;

class EmailHelper
{
    public function verify(string $email): bool
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        $arr = explode('@', $email);
        return getmxrr($arr[1], $hosts);
    }
}