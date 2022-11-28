<?php

require_once './source/EmailValidator.php';

$emails = [
    'artem@agsys2.ru',
    'artem@agsys.ru',
    'artem@bp-l.ru',
    'artem@yandex',
    'artem@yan.dex',
];

$result = (new EmailValidator())->setEmails($emails)->validate();
print_r($result);
