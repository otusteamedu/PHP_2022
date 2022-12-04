<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = new \Chernysh\EmailVerification\App();
foreach ($app->run() as $email => $checkResult) {
    echo $email . ': ' . $checkResult;
    echo '<br>';
}