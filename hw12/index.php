<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$host = '';
$database = '';

try {
    $user = new UserController($host, $database);
} catch (Exception $exception) {
    echo $exception->getMessage();
}
