<?php

namespace Otus\Mvc\Models;

use Otus\Mvc\Core\View;


class Email
{
    public $timestamps = false;

    public static function check()
    {
        if (!empty($_POST['check_email'])) {
            $email = filter_var($_POST['check_email'], FILTER_SANITIZE_EMAIL);
            $domain = substr(strrchr($email, "@"), 1);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            } else {
                if (!checkdnsrr($domain, 'MX')) {
                    return false;
                } else {
                    return true;
                }
            }
        }

    }
}
    

