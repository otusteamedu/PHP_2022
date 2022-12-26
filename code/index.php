<?php

declare(strict_types=1);

require_once "./vendor/autoload.php";

use Maldoshina\Php2022\EmailValidator;

$emails = [
    "test@yandex.ru",
    "",
    "qwer.ty@yandex.ru",
    "email@q1w2e3r4t5y6.ru",
    "email",
    "@mail.ru",
    "myemail@gmail.com",
    "my@email@gmail.com",
];

$validator = new EmailValidator();

foreach ($emails as $email) {
    try {
        $validator->validate($email);
    } catch (Exception $e) {
        echo $e->getMessage() . "<br>";
    }
}
