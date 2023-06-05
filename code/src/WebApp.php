<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16;

use Nikcrazy37\Hw16\Libs\Core\DI\DIContainer;
use Dotenv\Dotenv;

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
        } catch (\Throwable $e) {
            http_response_code($e->getCode());

            print_r($e->getMessage());

            echo "<br><pre>";
            print_r($e->getTraceAsString());
            echo "</pre>";
        }
    }
}