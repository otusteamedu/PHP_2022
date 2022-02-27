<?php

declare(strict_types=1);

use Philip\Otus\FrontController\FrontController;

require __DIR__ . '/../vendor/autoload.php';

$frontController = new FrontController;
$frontController->dispatchRequest();



