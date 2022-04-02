<?php

require_once './../vendor/autoload.php';

$app = new \App\App();
$response = $app->handle();

$response->send();
