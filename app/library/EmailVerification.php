<?php
namespace App\Verificator;

declare(strict_types=1);

define('EMAIL_VALIDATOR_ERROR_CODE_STRING',1);
define('EMAIL_VALIDATOR_ERROR_CODE_MX',2);

/**
 * Проверка Email на валидность, PHP 5 >= 5.2.0
 * - проверка на валидность строки
 * - проверка с MX
 * - проверка с учетом основных правил RFC 3696 -https://datatracker.ietf.org/doc/html/rfc3696
 */
class EmailVerification{
    const MAX_EMAIL_NAME_LENGTH = 64;
    const MAX_EMAIL_DOMAIN_LENGTH = 255;

    /**
     * @var null
     */
    public static $lastErrorCode = 0;

    /**
     * Check email, check correct or no
     * @param string $email
     * @param bool $mxCheck = true
     * @return bool
     */
    static function emailIsValid(string $email,bool $mxCheck = true) : bool{
        if (empty($email)) {
            self::$lastErrorCode = EMAIL_VALIDATOR_ERROR_CODE_STRING;
            return false;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            list($userName, $mailDomain) = explode("@", $email);
            if (strlen($userName)>self::MAX_EMAIL_NAME_LENGTH){
                self::$lastErrorCode = EMAIL_VALIDATOR_ERROR_CODE_STRING;
                return false;
            }
            if (strlen($mailDomain)>self::MAX_EMAIL_DOMAIN_LENGTH){
                self::$lastErrorCode = EMAIL_VALIDATOR_ERROR_CODE_STRING;
                return false;
            }
            if ($mxCheck) {
                if (checkdnsrr($mailDomain, "MX")){
                    return true;
                } else {
                    self::$lastErrorCode = EMAIL_VALIDATOR_ERROR_CODE_MX;
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}