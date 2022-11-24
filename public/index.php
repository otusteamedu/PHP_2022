<?php

declare(strict_types=1);

use Services\EmailValidator;

require "../src/Services/EmailValidator.php";

$emails = [
    'bobby@notexistsdomainqwerty.com',
    'akjwbdkjab@kjakjdba@jabd',
    'amanbs@mail.ru',
];

foreach ($emails as $email) {
    echo EmailValidator::validate($email) ? '[OK] '.$email.PHP_EOL : '[BAD] '.$email.PHP_EOL;
}