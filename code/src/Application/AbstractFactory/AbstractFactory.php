<?php

namespace Otus\App\Application\AbstractFactory;

use Otus\App\App;
abstract class AbstractFactory
{
    public static function getFactory()
    {
            $config = App::getConfig();
            switch ($config) {
                case 1:
                    return new ProductAbstractFactory();
                case 2:
                    return new TestAbstractFactory();
            }
            throw new \Exception('Bad config');

    }

    abstract public function create($type);
}