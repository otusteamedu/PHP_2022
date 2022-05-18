<?php

namespace Patterns\FactoryMethod;

class Aero implements TransportInterface
{

    public function load(): void
    {
        echo 'Загрузка самолета' . PHP_EOL;
    }

    public function deliver(string $cargo): void
    {
        echo "Доставка {$cargo} самолетом" . PHP_EOL;
    }

    public function unload(): void
    {
        echo 'Разгрузка самолета' . PHP_EOL;
    }
}
