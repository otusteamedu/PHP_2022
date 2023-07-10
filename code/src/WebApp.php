<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20;

use Nikcrazy37\Hw20\Libs\Core\DI\DIContainer;
use Dotenv\Dotenv;
use Nikcrazy37\Hw20\Libs\ExceptionHandler;
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
            $container->get("Routes");
        } catch (Throwable $e) {
            ExceptionHandler::printMessage($e);
        }
    }
}