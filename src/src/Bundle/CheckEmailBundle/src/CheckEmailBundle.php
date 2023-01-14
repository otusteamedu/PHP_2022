<?php

declare(strict_types=1);

namespace Bundle\CheckEmailBundle;

class CheckEmailBundle
{
    /**
     * Check email with php FILTER_VALIDATE_EMAIL & existing MX record
     *
     * @param string $email
     * @return bool
     */
    public static function isEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && getmxrr(explode("@", $email)[1], $hosts);
    }

    /**
     * Check list of emails & returns result as text
     *
     * @param string $emails_list
     * @param string $emails_separator
     * @return string
     */

    public static function checkEmailsList(string $emails_list, string $emails_separator): string
    {
        $result = '';

        foreach (explode($emails_separator, $emails_list) as $email) {
            $result .= $email . ' is ';
            $result .= self::isEmailValid($email) ? 'OK' : 'BAD';
            $result .= PHP_EOL;
        }

        return $result;
    }
}