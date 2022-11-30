<?php

require '../vendor/autoload.php';

use Pinguk\Validator\Validators\EmailValidator;

$emails = [
    'bobby@notexistsdomainqwerty.com',
    'akjwbdkjab@kjakjdba@jabd',
    'amanbs@mail.ru',
];

$emailValidator = new EmailValidator();
$validations = $emailValidator->validateEmails($emails);

foreach ($validations as $validation) {
    echo $validation->getResult();
}