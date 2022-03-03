<?php

namespace Queen\App\EmailChecker;

class EmailChecker
{
    protected string $pattern = "/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i";

    /**
     * @param $email
     *
     * @return bool
     */
    public function checkEmail($email)
    {
        $email = trim($email);
        $result = false;

        if (strlen($email) > 255) {
            return false;
        }

        if (substr_count($email, '@') > 1) {
            return false;
        }

        if (!preg_match($this->pattern, $email)) {
            return false;
        }

        if (function_exists('filter_var') && defined('FILTER_VALIDATE_EMAIL')) {
            $result = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        if ($result) {
            $domain = explode('@', $email);
            if (!checkdnsrr($domain[1], "MX") && !checkdnsrr($domain[1], "A")) {
                $result = false;
            }
        }

        return $result;
    }
}
