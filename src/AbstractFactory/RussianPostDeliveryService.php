<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\DeliveryServiceInterface;
use Patterns\AbstractFactory\interfaces\PackageInterface;

class RussianPostDeliveryService implements DeliveryServiceInterface
{

    /**
     * @param PackageInterface $package
     *
     * @return void
     */
    public function sendPackage(PackageInterface $package)
    {
        echo 'Отправляем посылку через Почту России' . PHP_EOL;
    }
}
