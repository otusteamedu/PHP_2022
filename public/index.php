<?php

use App\Http\ExceptionHandler;
use App\Http\Response;

require_once './../vendor/autoload.php';

$handler = new ExceptionHandler();

$app = new \App\App();
$response = $app->handle();

$response->send();
