<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw5;

use Veraadzhieva\Hw5\Service\EmailValidator;

class Emails
{
    /*
     * Обработка массива email-ов.
     *
     * @param array $emails
     *
     * @return void
     */
    public function getEmails(array $emails) {
        $validate = new EmailValidator();
        $newEmails = [];
        foreach ($emails as $email) {
            if ($validate->emailValidator($email)) {
                array_push($newEmails, $email);
            }
        }
        return $newEmails;
    }
}