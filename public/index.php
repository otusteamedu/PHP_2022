<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
$app = require_once '../bootstrap/app.php';

$request = \App\Infrastructure\Http\ServerRequest::createFromGlobals();
$app->run($request);