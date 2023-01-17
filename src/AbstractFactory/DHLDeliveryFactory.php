<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\AbstractFactoryInterface;

class DHLDeliveryFactory implements AbstractFactoryInterface
{
    /**
     * @return DHLDeliveryService
     */
    public function createDeliveryService(): DHLDeliveryService
    {
        return new DHLDeliveryService();
    }

    /**
     * @return DHLPackage
     */
    public function createPackage(): DHLPackage
    {
        return new DHLPackage();
    }
}
