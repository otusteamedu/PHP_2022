<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
$app = require_once '../bootstrap/webApp.php';

$request = \App\Infrastructure\Http\ServerRequest::createFromGlobals();
$app->run($request);