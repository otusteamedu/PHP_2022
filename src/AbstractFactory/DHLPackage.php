<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class DHLPackage implements PackageInterface
{

    /**
     * @return string
     */
    public function getConsist(): string
    {
        return 'Проверяем содержимое посылки DHL' . PHP_EOL;
    }
}
