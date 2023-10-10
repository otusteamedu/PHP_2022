<?php

declare(strict_types=1);

namespace App\Factory;

use App\Application;
use Psr\Container\ContainerInterface;

class AppFactory
{
    public static function create(ContainerInterface $container): Application
    {
        return new Application($container);
    }
}
