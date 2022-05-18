<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class YandexPackage implements PackageInterface
{

    /**
     * @return void
     */
    public function getConsist(): void
    {
        echo 'Проверяем содержимое посылки Yandex' . PHP_EOL;
    }
}
