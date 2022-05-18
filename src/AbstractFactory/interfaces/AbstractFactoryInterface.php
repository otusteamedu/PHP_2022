<?php

namespace Patterns\AbstractFactory\interfaces;

interface AbstractFactoryInterface
{
    public function createDeliveryService(): DeliveryServiceInterface;

    public function createPackage(): PackageInterface;
}
