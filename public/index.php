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

$validator = new EmailValidator($emails);

foreach ($validator->getInvalid() as $invalid) {
    echo '<strong>' . $invalid . '</strong> не действителен<br>';
}