<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';

if (preg_match('/\.(css|js|gif|jpg|png|svg)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}


\App\Users\Router::start();