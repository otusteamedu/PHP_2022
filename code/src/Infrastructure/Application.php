<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure;

use Nikolai\Php\Application\Container\ContainerBuilder;
use Nikolai\Php\Infrastructure\Configuration\Configuration;
use Nikolai\Php\Infrastructure\ControllerResolver\ControllerResolver;
use Symfony\Component\HttpFoundation\Request;

class Application implements ApplicationInterface
{
    public function run(): void
    {
        $configuration = (new Configuration())->load();
        $request = Request::createFromGlobals();
        $container = (new ContainerBuilder($request, $configuration))->build();

        $consoleCommand = $request->server->get('argv')[1] ?? '';
        $controllerClass = (new ControllerResolver($consoleCommand))->resolve();

        $controller = $container->get($controllerClass);
        $controller($request);
    }
}
