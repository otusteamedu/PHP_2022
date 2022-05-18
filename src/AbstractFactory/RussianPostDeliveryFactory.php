<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\AbstractFactoryInterface;

class RussianPostDeliveryFactory implements AbstractFactoryInterface
{

    /**
     * @return RussianPostDeliveryService
     */
    public function createDeliveryService(): RussianPostDeliveryService
    {
        return new RussianPostDeliveryService();
    }

    /**
     * @return RussianPostPackage
     */
    public function createPackage(): RussianPostPackage
    {
        return new RussianPostPackage();
    }
}
