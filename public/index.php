<?php

require '../vendor/autoload.php';

use Pinguk\Validator\Validators\EmailValidator;

$emails = [
    'bobby@notexistsdomainqwerty.com',
    'akjwbdkjab@kjakjdba@jabd',
    'amanbs@mail.ru',
];

foreach ($emails as $email) {
    $validation = EmailValidator::validate($email);

    if (!$validation->isValid) {
        echo 'Некорректная эл. почта: '.$email.PHP_EOL;
    }
}