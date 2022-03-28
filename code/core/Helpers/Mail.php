<?php

namespace Core\Helpers;

use App\Application;
use Core\Base\Validator;
use Core\Widgets\Alert;
use Core\Exceptions\InvalidArgumentException;

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

    /**
     * @throws InvalidArgumentException
     */
    public static function checkEmail(string $email): void
    {
        $validator = new Validator();
        $validator->validated($email, ['required', 'email']);

        if ($validator->check()) {
            if ($dns = self::mxRecordValidate($email)) {
                Application::$app->getSession()
                                 ->alertMessage()
                                 ->setFlashMessage('success', $email . ' validate email is successful', Alert::FLASH_SUCCESS);
                Application::$app->getSession()
                                 ->alertMessage()
                                 ->setFlashMessage('mx_record', 'This MX records exists: target - ' . $dns, Alert::FLASH_INFO);
            } else {
                throw new InvalidArgumentException('This MX records is not exists for email ' . $email);
            }
        } else {
           throw new InvalidArgumentException($validator->getErrorsToString());
        }
    }
}