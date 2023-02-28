<?php

namespace Katya\hw5\Controllers;

class EmailValidation extends \Katya\hw5\Users\Controller
{
    public function getEmailResult()
    {
        $email=$_POST['getEmailResult'];
        if (!empty($email)){
            if (filter_var($email, FILTER_VALIDATE_EMAIL) & $this->isValidHost($email)) {
                echo "Хорошо)";
            }else{
                echo "Нехорошо(";
            }
        }
    }
    public function isValidHost($email):bool
    {
        [$login, $host] = explode('@', $email);

        return getmxrr($host, $hosts);

    }
}