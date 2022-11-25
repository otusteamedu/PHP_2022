<?php

require '../vendor/autoload.php';

use Pinguk\Validator\Services\EmailValidator;

const BAD_STRING = 'Эл. почта некорректная. Пример корректной: andrew@mail.ru';
const BAD_MX_RECORD = 'Некорректная MX-запись';

$emails = [
    'bobby@notexistsdomainqwerty.com',
    'akjwbdkjab@kjakjdba@jabd',
    'amanbs@mail.ru',
];

foreach ($emails as $email) {
    $isValidString = EmailValidator::validateString($email);
    if (!$isValidString) {
        echo '[BAD] '.$email.'. Причина: '.BAD_STRING.PHP_EOL;
        continue;
    }

    $isValidMXRecord = EmailValidator::validateMXRecord($email);
    if (!$isValidMXRecord) {
        echo '[BAD] '.$email.'. Причина: '.BAD_MX_RECORD.PHP_EOL;
        continue;
    }

    echo '[OK] '.$email.PHP_EOL;
}