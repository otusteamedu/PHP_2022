<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$service = new VeraAdzhieva\Hw3\Service\Age();
$app = new VeraAdzhieva\Hw3\App($service);
$app->run();
