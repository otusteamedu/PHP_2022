<?php

declare(strict_types=1);

namespace App;

use App\Service\InstanceChecker;
use Olelishna\EmailVerifier\Verifier;

class App
{
    public static function run(): string
    {
        InstanceChecker::addHeader();

        $arrayOfEmails = [
            'test@example.com',
            'olelishna@gmail.com',
            'olga@hello.com',
            'olga@hello,com',
            'olga@gmai.com',
        ];

        $resultArray = Verifier::check($arrayOfEmails);

        return json_encode($resultArray);
    }
}
