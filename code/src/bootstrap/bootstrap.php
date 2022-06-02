<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;

session_start();

require 'vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__ . '/../../');
$env->load();
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$container = $containerBuilder->build();