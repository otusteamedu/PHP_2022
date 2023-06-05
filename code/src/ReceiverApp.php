<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16;

use Nikcrazy37\Hw16\Libs\Core\DI\DIContainer;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\Receiver;
use Dotenv\Dotenv;

class ReceiverApp
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $container = DIContainer::build();

            $container->get(Dotenv::class);
            $container->get(Receiver::class);
        } catch (\Throwable $e) {
            http_response_code($e->getCode());

            print_r($e->getMessage());

            echo "<br><pre>";
            print_r($e->getTraceAsString());
            echo "</pre>";
        }
    }
}