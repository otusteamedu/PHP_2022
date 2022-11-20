<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw5;

use Veraadzhieva\Hw5\Service\EmailValidator;

class Emails
{

    /** @var EmailValidator */
    private $emailValidator;

    /**
     * App constructor.
     * @param EmailValidator $emailValidator
     */
    public function __construct(EmailValidator $emailValidator)
    {
        $this->emailValidator = $emailValidator;
    }

    /*
     * Обработка массива email-ов.
     *
     * @return void
     */
    public function run() {
        $validate = new EmailValidator();
        $emails = [
            'v.adzhieva@mail.ru',
            'vvv.vvv.@vvv.vv',
            'otus@otus.otus',
            'rose@gmail.com',
            'yandex123@yandex.ru'
        ];
        $newEmails = [];
        foreach ($emails as $email) {
            if ($validate->emailValidator($email)) {
                array_push($newEmails, $email);
            }
        }
        print_r($newEmails);
    }
}