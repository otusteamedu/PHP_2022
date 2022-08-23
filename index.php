<?php

use App\Verificator\EmailVerification;

require_once 'app/library/EmailVerification.php';

$forCheckEmailList = [
    'pasha@mail.ru',
    'studio@webboss29283482034.pro',
    'studio@webboss.pro',
    'studio@webbo@ss.pro',
    'studio@webboss.prО',
    'studio@webb.oss.tatata',
    '@webb.oss.tatata',
    'webb.oss.tatata',
    'webb.oss.tat@ta',
    'фывфыв@asdasd.ru',
    'фывфыв@asdasd.ru',
    '"Abc@def"@example.com'
];
$i = 1;
$result = '';
foreach ($forCheckEmailList as $email){
    $result .= $i.' '.$email.' '.(EmailVerification::emailIsValid($email) ? 'ok' : 'no')."\n";
    $i++;
}

echo EmailVerification::emailIsValid('admin@test,ru') ? 'ok' : 'no';