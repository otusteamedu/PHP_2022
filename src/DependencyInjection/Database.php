<?php

namespace Patterns\DependencyInjection;

class Database implements DatabaseInterface
{

    public function connect(): string
    {
        return 'Успешное соединение с Базой Данных' . PHP_EOL;
    }
}
