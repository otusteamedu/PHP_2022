<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16;

use Nikcrazy37\Hw16\Libs\Core\DI\DIContainer;
use Dotenv\Dotenv;
use Nikcrazy37\Hw16\Libs\ExceptionHandler;
use Throwable;

class WebApp
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $container = DIContainer::build();

            $container->get(Dotenv::class);
            $container->get(Router::class);
        } catch (Throwable $e) {
            ExceptionHandler::printMessage($e);
        }
    }
}