<?php
use app\controllers\Controller;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'./../');
$dotenv->load();

echo (new Controller())->run();
