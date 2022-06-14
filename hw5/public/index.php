<?php

use Katya\hw5\Users\Router;


require_once '../vendor/autoload.php';

if (preg_match('/\.(css|js|gif|jpg|png|svg)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

Katya\hw5\Users\Router::start();
