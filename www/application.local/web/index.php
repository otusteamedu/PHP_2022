<?php

use app\controllers\SandboxController;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

echo (new SandboxController())->run();
