<?php

declare(strict_types=1);

namespace ATolmachev\App;

use Carabidaee\Validators\EmailValidator;

class App
{
    public function run(): string
    {
        $emailsList = $_GET['emails'] ?? null;
        if (empty($emailsList)) {
            return 'Ошибка! Вы не передали аргумент emails или передали его пустым.';
        }
        if (!\is_array($emailsList)) {
            return 'Ошика! Аргумент emails должен быть массивом.';
        }

        $response = '';

        $emailValidator = new EmailValidator();
        if (!$emailValidator->validate($emailsList)) {
            foreach ($emailValidator->getErrors() as $error) {
                $response .= "Email {$error['email']} incorrect: {$error['errorText']}<br>";
            }
        }

        foreach ((array)$emailValidator->getCorrectEmails() as $email) {
            $response .= "Email {$email} correct<br>";
        }

        return $response;
    }
}
