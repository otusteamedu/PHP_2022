<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\DeliveryServiceInterface;
use Patterns\AbstractFactory\interfaces\PackageInterface;

class YandexDeliveryService implements DeliveryServiceInterface
{

    /**
     * @param PackageInterface $package
     *
     * @return void
     */
    public function sendPackage(PackageInterface $package): void
    {
        echo 'Отправляем посылку через Yandex' . PHP_EOL;
    }
}
