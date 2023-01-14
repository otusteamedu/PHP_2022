<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \AKhakhanova\Hw3\Service\StringService();
$app     = new \AKhakhanova\Hw3\App($service);
$app->run();
