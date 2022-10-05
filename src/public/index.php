<?php

declare(strict_types=1);

require_once dirname(__FILE__) . '/../bootstrap.php';

try {
    \App\Router::start($config, $messenger); // запускаем маршрутизатор
} catch (Throwable $e)
{
    echo "Произошла ошибка:".$e->getMessage();
}
