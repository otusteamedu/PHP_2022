<?php

declare(strict_types=1);

namespace Philip\Otus\FrontController\View;

use Redis;
use Philip\Otus\Validators\Validator;
use Philip\Otus\Validators\Rules\EmailRule;
use Philip\Otus\Validators\Rules\EmailDnsRule;
use Philip\Otus\Validators\Exceptions\ValidationException;

class HomeView
{
    public function show()
    {
        $redis = new Redis();
        $redis->connect('redis');
        $validator = Validator::instance();
        $emails = $this->getEmails();
        foreach ($emails as $email) {
            try {
                $validator->validate(
                    ['email' => [new EmailRule(), new EmailDnsRule($redis)]],
                    ['email' => $email]
                );
                dump("Email ($email) is valid");
            } catch (ValidationException $exception) {
                $errors = $exception->errors();
                [$error] = $errors['email'];
                dump([$email, $error]);
            }
        }
    }

    private function getEmails(): array
    {
        return [
            "a1@email.com",
            "a2@mail.ru",
            "a3@gmail.com",
            "a4@yandex.com",
            "a5@yasd.com",
            "a6yasd.com",
            "a7@rambler.com"
        ];
    }
}