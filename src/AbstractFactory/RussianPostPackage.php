<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class RussianPostPackage implements PackageInterface
{

    /**
     * @return string
     */
    public function getConsist(): string
    {
        return 'Проверяем содержимое посылки Почты России' . PHP_EOL;
    }
}
