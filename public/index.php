<?php

use Dmitry\App\Validators\EmailValidator;

require_once '../vendor/autoload.php';

$emails = [
    'test@mail.ru',
    'test_@mail.ru',
    'test.2022@mail.ru',
    'тест@mail.ru',
    'тест',
    'test@mail',
    'test@fsdfsdfsdf.ru',
    '%32&%4@mail.ru',
    'test@mail.ru2313124%'
];

if (EmailValidator::hasValidInArray($emails)) {
    foreach (EmailValidator::validateArray($emails) as $email => $valid) {
        if ($valid) {
            continue;
        }

        echo '<strong>' . $email . '</strong> не валидный<br>';
    }
} else {
    echo 'В массиве нет валидных e-mail';
}