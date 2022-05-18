<?php

namespace Patterns\AbstractFactory;

require __DIR__ . '/../../vendor/autoload.php';

function delivery(array $factories) {
    foreach ($factories as $factory) {
        $deliveryService = $factory->createDeliveryService();
        $package = $factory->createPackage();
        $package->getConsist();
        $deliveryService->sendPackage($package);
    }
}

$factories = [
    new DHLDeliveryFactory(),
    new YandexDeliveryFactory(),
    new RussianPostDeliveryFactory()
];

delivery($factories);
