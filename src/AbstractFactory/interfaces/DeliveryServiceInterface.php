<?php

namespace Patterns\AbstractFactory\interfaces;

interface DeliveryServiceInterface
{
    public function sendPackage(PackageInterface $package);
}
