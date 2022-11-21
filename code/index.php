<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$app = new \Chernysh\EmailVerification\App();
echo $app->run();