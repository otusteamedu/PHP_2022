<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
new Redis;

$dbUser = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PASSWORD'];
$dnc = sprintf('pgsql:host=postgres;port=5432;dbname=%s;', $_ENV['DB_NAME']);
$dbh = new PDO($dnc, $dbUser, $dbPassword);

new Memcached;


phpinfo();