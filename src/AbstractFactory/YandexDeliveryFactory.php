<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\AbstractFactoryInterface;
use Patterns\AbstractFactory\interfaces\DeliveryServiceInterface;
use Patterns\AbstractFactory\interfaces\PackageInterface;

class YandexDeliveryFactory implements AbstractFactoryInterface
{

    /**
     * @return YandexDeliveryService
     */
    public function createDeliveryService(): YandexDeliveryService
    {
        return new YandexDeliveryService();
    }

    /**
     * @return YandexPackage
     */
    public function createPackage(): YandexPackage
    {
        return new YandexPackage();
    }
}
