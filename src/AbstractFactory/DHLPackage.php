<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class DHLPackage implements PackageInterface
{

    /**
     * @return void
     */
    public function getConsist(): void
    {
        echo 'Проверяем содержимое посылки DHL' . PHP_EOL;
    }
}
