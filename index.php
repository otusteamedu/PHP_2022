<?php

use Pinguk\RedisLearn\App;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new App();
$app->run();
