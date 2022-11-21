<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \Chernysh\EmailVerification\Service\EmailVerification();
$app = new \Chernysh\EmailVerification\App($service);
$app->run();