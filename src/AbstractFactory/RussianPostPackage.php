<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class RussianPostPackage implements PackageInterface
{

    /**
     * @return void
     */
    public function getConsist()
    {
        echo 'Проверяем содержимое посылки Почты России' . PHP_EOL;
    }
}
