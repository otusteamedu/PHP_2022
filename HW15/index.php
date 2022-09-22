<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Application;

//Инжектируем зависмости, нужные для работы приложения
$pdo = new \PDO('mysql:host=localhost;dbname=test', 'test_user', 'test_password');
$storage = new \App\Infrastructure\ProductStorage($pdo);

//Создаем приложение
$App = new Application\App($storage);
try {
    //Запускаем
    $App->run();
} catch(\Throwable $exception) {
    echo "Произошла ошибка: " . $exception->getMessage();
}