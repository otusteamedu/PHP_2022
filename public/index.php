<?php

declare(strict_types=1);

use Philip\Otus\Core\App;
use Philip\Otus\Core\Dispatcher;

require __DIR__ . '/../vendor/autoload.php';

$frontController = new App;
$frontController->dispatchRequest(Dispatcher::VIEW_GREETING);



