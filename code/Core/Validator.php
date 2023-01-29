<?php

declare(strict_types=1);

namespace Core;

class Validator
{
    public function validateEmail($email)
    {
        $sym_pos = strrchr($email, "@");
        if (!$sym_pos) {
            return false;
        }
        $domain = substr($sym_pos, 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null  || $mx_records[0] == "0.0.0.0"))) {
            return false;
        } else {
            return true;
        }
    }
}
