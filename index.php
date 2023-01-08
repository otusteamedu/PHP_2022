<?php

use Pinguk\ElasticApp\App;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new App();
$app->execute();
