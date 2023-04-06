<?php

declare(strict_types=1);

use Svatel\Code\App;

include __DIR__ . '/vendor/autoload.php';

//$db = new PDO('mysql:host=host.docker.internal;dbname=db', 'user', 'password111');
//print_r($db);
try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Произошла ошибка';
}