<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \Sveta\Code\Services\CheckStrings();
$requestStatus = new \Sveta\Code\Http\RequestStatus();
$app = new \Sveta\Code\App($service, $requestStatus);
print_r($app->run());
