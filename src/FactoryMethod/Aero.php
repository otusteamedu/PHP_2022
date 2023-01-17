<?php

namespace Patterns\FactoryMethod;

class Aero implements TransportInterface
{

    public function load(): string
    {
        return 'Загрузка самолета' . PHP_EOL;
    }

    public function deliver(string $cargo): string
    {
        return "Доставка {$cargo} самолетом" . PHP_EOL;
    }

    public function unload(): string
    {
        return 'Разгрузка самолета' . PHP_EOL;
    }
}
