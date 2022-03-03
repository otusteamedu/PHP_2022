<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require 'vendor/autoload.php';

define('ROOT', dirname(__DIR__));
define('CONFIG', __DIR__);

$env = ROOT . '/.env';
if (file_exists($env)) {
    $dotenv = new Dotenv(true);
    $dotenv->load($env);
}

