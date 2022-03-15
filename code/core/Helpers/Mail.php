<?php

namespace Core\Helpers;

class Mail
{

    /**
     * @param string $email
     * @return false|mixed
     */
    public static function mxRecordValidate(string $email)
    {
        $domain = substr(strrchr($email, "@"), 1);

        $dns = dns_get_record($domain, DNS_MX);

        if (count($dns) > 0 && $dns[0]['host'] === $domain && !empty($dns[0]['target'])) {
            return $dns[0]['target'];
        }

        return false;
    }
}