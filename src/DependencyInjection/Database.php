<?php

namespace Patterns\DependencyInjection;

class Database implements DatabaseInterface
{

    public function connect()
    {
        echo 'Успешное соединение с Базой Данных' . PHP_EOL;
    }
}
