<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure;

use Nikolai\Php\Application\Container\ContainerBuilder;
use Nikolai\Php\Infrastructure\Configuration\Configuration;
use Nikolai\Php\Infrastructure\ControllerResolver\ControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application implements ApplicationInterface
{
    public function run(): void
    {
        $configuration = (new Configuration())->load();
        $request = Request::createFromGlobals();
        $container = (new ContainerBuilder($request, $configuration))->build();

        $controllerClass = (new ControllerResolver($request, $configuration))->resolve();
        $controller = $container->get($controllerClass);
        $response = $controller($request);

        if ($response instanceof Response) {
            $response->send();
        }
    }
}
