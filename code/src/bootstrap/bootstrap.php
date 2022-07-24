<?php
declare(strict_types=1);

use Dotenv\Dotenv;

session_start();

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__ . '/../../');
$env->load();
$env->required([
    'DB_USERNAME',
    'DB_PASSWORD',
    'DB_DATABASE',
    'DB_CONNECTION',
    'DB_HOST',
]);