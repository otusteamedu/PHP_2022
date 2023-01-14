<?php

require(__DIR__) . '/../vendor/autoload.php';

use Octopus\Php2022\Service\EmailValidator;

$emails = [
    'test@mail.ru',
    'test_@mail.ru',
    'test.2022@mail.ru',
    'тест@mail.ru',
    'тест',
    'test@mail',
    'test@fsdfsdfsdf.ru',
    '%32&%4@mail.ru',
    'test@mail.ru2313124%',
    'samirtula@mail.ru'
];

try {
    echo '<pre>';
    print_r((new EmailValidator($emails))->validate());
    echo '</pre>';
} catch (Exception $e) {
    echo $e->getMessage();
}
