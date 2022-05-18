<?php

namespace Patterns\FactoryMethod;

require __DIR__ . '/../../vendor/autoload.php';

function clientCode(Logistic $logistic, string $cargo) {
    $logistic->deliverCargo($cargo);
}

clientCode(new TruckLogistic(), 'Чай');

echo PHP_EOL;

clientCode(new AeroLogistic(), 'Конфеты');
