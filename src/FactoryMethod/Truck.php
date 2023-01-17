<?php

namespace Patterns\FactoryMethod;

class Truck implements TransportInterface
{

    public function load(): string
    {
        return 'Загрузка грузовика' . PHP_EOL;
    }

    public function deliver(string $cargo): string
    {
        return "Доставка {$cargo} грузовиком" . PHP_EOL;
    }

    public function unload(): string
    {
        return 'Разгрузка грузовика' . PHP_EOL;
    }
}
