<?php

require(__DIR__) . '/../vendor/autoload.php';

use Octopus\Php2022\Service\EmailValidator;

$app = new EmailValidator();
$response = $app->verify('gahraman.89@mail.ru');

var_dump($response);
