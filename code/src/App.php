<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13;

use Nikcrazy37\Hw13\Libs\Exception\BaseException;

class App
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            new Router();
        } catch (BaseException $e) {
            http_response_code($e->getCode());
            print_r($e->getMessage());
        }
    }
}