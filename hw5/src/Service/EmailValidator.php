<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw5\Service;

class EmailValidator
{
    /*
     * Проверка email на корректность.
     *
     * @param string $email
     *
     * @return bool
     */
    public function emailValidator(string $email): bool {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->checkDnsMx($email);
        } else {
            return false;
        }
    }

    /*
     * Проверка DNS MX.
     *
     * @param string $email
     *
     * @return bool
     */
    private function checkDnsMx($email): bool {
        $domain = strrchr($email, "@");
        getmxrr($domain, $mx);
        return !empty($mx);
    }

}