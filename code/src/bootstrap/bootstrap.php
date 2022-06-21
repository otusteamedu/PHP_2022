<?php
declare(strict_types=1);

use Dotenv\Dotenv;

session_start();

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__ . '/../../');
$env->load();
$env->required(['STORAGE']);