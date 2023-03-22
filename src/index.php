<?php

declare(strict_types=1);

use Project\Validator\Email\EmailValidatorException;
use Project\Validator\Email\Validator;
use Project\Validator\Data\EmailValidationData;

require_once "./vendor/autoload.php";

$emails = [
    'andruxa1992a@yandex.ru',
    'bla@blz.mb',
    'test@test.com',
    1,
    [],
    null,
    false,
];

$validator = new Validator();

$validEmails = [];
$notValidEmails = [];
$fatalData = [];

foreach ($emails as $email) {
    try {
        $validator->validation(EmailValidationData::create($email));
    } catch (EmailValidatorException $emailValidatorException) {
        $notValidEmails[] = $email;

        continue;
    } catch (Throwable $exception) {
        $fatalData[] = $email;

        continue;
    }

    $validEmails[] = $email;
}

echo 'Валидные email: ' . implode(', ', $validEmails)
    . '<br>'
    . 'Невалидные email: ' . implode(', ', $notValidEmails)
    . '<br>'
    . 'Данные который не смогли обработать: ' . print_r($fatalData, true);
