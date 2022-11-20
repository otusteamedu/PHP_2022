<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$service = new Veraadzhieva\Hw5\Service\EmailValidator();
$app = new Veraadzhieva\Hw5\Emails($service);
$app->run();