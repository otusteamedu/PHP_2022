<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \Chernysh\Hw4\Service\CheckStringService();
$app = new \Chernysh\Hw4\App($service);
$app->run();