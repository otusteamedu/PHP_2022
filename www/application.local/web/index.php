<?php

use app\components\SlimApplication;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

(new SlimApplication())->run();
