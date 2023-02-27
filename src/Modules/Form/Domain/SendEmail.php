<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Domain;

class SendEmail
{
    public static function run(string $email, string $message)
    {
        $headers = [
            'From' => 'hw16@otus_hw.com',
            'X-Mailer' => 'PHP/' . phpversion()
        ];
        mail($email, 'Выписка', $message, $headers);
    }
}
