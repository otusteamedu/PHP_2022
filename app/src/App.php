<?php

declare(strict_types=1);

namespace ATolmachev\App;

use Carabidaee\Validators\EmailValidator;

class App
{
    public function run(): string
    {
        // correct
        $emailsList[] = 'carabidaee@gmail.com';
        $emailsList[] = 'carabidee@yandex.com';

        // incorrect
        $emailsList[] = '.12@gmail.com';
        $emailsList[] = 'русский_язык@mail.ru';
        $emailsList[] = 'unknown@unknows.com';

        $response = '';

        $emailValidator = new EmailValidator();
        if (!$emailValidator->validate($emailsList)) {
            foreach ($emailValidator->getErrors() as $error) {
                $response .= "Email {$error['email']} incorrect: {$error['errorText']}\n";
            }
        }

        foreach ((array) $emailValidator->getCorrectEmails() as $email) {
            $response .= "Email {$email} correct\n";
        }

        return $response;
    }
}