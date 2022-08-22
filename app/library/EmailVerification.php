<?php
namespace App\Verificator;

define('EMAIL_VALIDATOR_ERROR_CODE_STRING',1);
define('EMAIL_VALIDATOR_ERROR_CODE_MX',2);

/**
 * Проверка Email на валидность, PHP 5 >= 5.2.0
 * - проверка на валидность строки
 * - проверка с MX
 * - проверка с учетом основных правил RFC 3696 -https://datatracker.ietf.org/doc/html/rfc3696
 */
class EmailVerification{

    /**
     * @var null
     */
    static $lastErrorCode = 0;

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
            if (strlen($userName)>64){
                self::$lastErrorCode = EMAIL_VALIDATOR_ERROR_CODE_STRING;
                return false;
            }
            if (strlen($mailDomain)>255){
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

    /**
     * Test function
     * @return string
     */
    static function selfCheck() : string{
        $forCheckEmailList = [
            'pasha@mail.ru',
            'studio@webboss29283482034.pro',
            'studio@webboss.pro',
            'studio@webbo@ss.pro',
            'studio@webboss.prО',
            'studio@webb.oss.tatata',
            '@webb.oss.tatata',
            'webb.oss.tatata',
            'webb.oss.tat@ta',
            'фывфыв@asdasd.ru',
            'фывфыв@asdasd.ru',
            '"Abc@def"@example.com'
        ];
        $i = 1;
        $result = '';
        foreach ($forCheckEmailList as $email){
            $result .= $i.' '.$email.' '.(EmailVerification::emailIsValid($email) ? 'ok' : 'no')."\n";
            $i++;
        }
        return $result;
    }
}