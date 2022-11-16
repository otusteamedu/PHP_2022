<?php

require __DIR__ . '/../vendor/autoload.php';

use Waisee\EmailValidator\Helpers\EmailHelper;

$emails = [
    'danil.baluev@rt.ru',
    'waisee@bk.ru',
    'waisee7@gmail.com',
    'fadsfsd@fads.ru',
    'test@test.ru',
    'fasdfsdfa',
];

$helper = new EmailHelper();
foreach ($emails as $email) {
    if($helper->verify($email)) {
        echo 'Email ' . $email . ' is ok<br>';
    } else {
        echo 'Email ' . $email . ' validation is failed<br>';
    }
}
return true;

