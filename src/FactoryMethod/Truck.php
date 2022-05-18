<?php

namespace Patterns\FactoryMethod;

class Truck implements TransportInterface
{

    public function load(): void
    {
        echo 'Загрузка грузовика' . PHP_EOL;
    }

    public function deliver(string $cargo): void
    {
        echo "Доставка {$cargo} грузовиком" . PHP_EOL;
    }

    public function unload(): void
    {
        echo 'Разгрузка грузовика' . PHP_EOL;
    }
}
