<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$emails = [
    'v.adzhieva@mail.ru',
    'vvv.vvv.@vvv.vv',
    'otus@otus.otus',
    'rose@gmail.com',
    'yandex123@yandex.ru'
];

$email_verification = new Veraadzhieva\Hw5\Emails();
$email_verification->getEmails($emails);