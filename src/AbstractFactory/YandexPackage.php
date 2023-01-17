<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\interfaces\PackageInterface;

class YandexPackage implements PackageInterface
{

    /**
     * @return string
     */
    public function getConsist(): string
    {
        return 'Проверяем содержимое посылки Yandex' . PHP_EOL;
    }
}
