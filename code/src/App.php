<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5;

use Nikcrazy37\Hw5\Router;

class App
{
    /**
     * @return void
     */
    public function run()
    {
        try {
            new Router();
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            print_r($e->getMessage());
        }
    }
}