<?php

declare(strict_types=1);

use Philip\Otus\Validators\Rules\EmailDnsRule;
use Philip\Otus\Validators\Rules\EmailRule;
use Philip\Otus\Validators\Validator;

require __DIR__ . '/../vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis');
$validator = Validator::instance();
$emails = json_decode(file_get_contents(__DIR__.'/emails.json'), true);

foreach ($emails as $email) {
    $result = $validator->validate(
        ['email' => [new EmailRule(), new EmailDnsRule($redis)]],
        ['email' => $email]
    );
    if ($result) {
        dump("Email ($email) is valid");
    }else {
        dump([$email, $validator->errors()->all()['email'][0]]);
    }
}

