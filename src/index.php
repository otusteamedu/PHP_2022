<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\EmailValidator;

echo "<pre>";
$validator = new EmailValidator(
    emails: [
        'simple@example.com',
        'very.common@example.com',
        'abc@example.co.uk',
        'disposable.style.email.with+symbol@example.com',
        'other.email-with-hyphen@example.com',
        'fully-qualified-domain@example.com',
        'user.name+tag+sorting@example.com',
        'example-indeed@strange-example.com',
        23,
        'help@otus.ru'
    ]
);
var_dump($validator->validate()->toArray());
echo "</pre>";

echo "<hr>";

$validator = new EmailValidator(emails: 45);

echo "<pre>";
var_dump($validator->validate()->toString());
echo "</pre>";