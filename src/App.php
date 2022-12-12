<?php

declare(strict_types=1);

namespace Sveta\Php2022;

class App
{
    private EmailChecker $emailChecker;

    public function __construct()
    {
        $this->emailChecker = new EmailChecker();
    }

    public function run(array $emails): array
    {
        $res = [];

        foreach ($emails as $email) {
            if (!empty($email)) {
                if ($this->emailChecker->checkEmail($email)) {
                    $res[$email] = 'Email существует';
                } else {
                    $res[$email] = 'Email не существует';
                }
            } else {
                $res[$email] = 'Пустое значение';
            }
        }

        return $res;
    }
}
