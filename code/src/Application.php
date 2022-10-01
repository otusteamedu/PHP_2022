<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Configuration\ConfigurationLoader;
use Nikolai\Php\Kernel\Kernel;
use Symfony\Component\HttpFoundation\Request;

class Application implements ApplicationInterface
{
    public function __construct()
    {
        (new ConfigurationLoader())->load();
    }

    public function run(): void
    {
        try {
            $request = Request::createFromGlobals();
            $response = (new Kernel())->process($request);
            $response?->send();
        } catch (\Exception $exception) {
            echo 'Исключение: ' . $exception->getMessage() . PHP_EOL;
        }
    }
}