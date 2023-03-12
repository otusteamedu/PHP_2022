<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();

$bindings = require __DIR__ . '/../config/di.php';
$container = new \App\Infrastructure\DI\Container();
foreach ($bindings as $interface => $binding) {
    $container->set($interface, $binding);
}

return $container;
