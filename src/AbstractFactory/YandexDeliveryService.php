<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\DeliveryServiceInterface;
use Patterns\AbstractFactory\interfaces\PackageInterface;

class YandexDeliveryService implements DeliveryServiceInterface
{

    /**
     * @param PackageInterface $package
     *
     * @return string
     */
    public function sendPackage(PackageInterface $package): string
    {
        return 'Отправляем посылку через Yandex' . PHP_EOL;
    }
}
