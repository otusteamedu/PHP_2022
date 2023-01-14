<?php

require __DIR__ . '/vendor/autoload.php';

$service = new \Larisadebelova\Php2022\Services\StringService();
$app = new \Larisadebelova\Php2022\App($service);
$app->run();
