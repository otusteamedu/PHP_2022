<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure;

use Nikolai\Php\Infrastructure\Configuration\Configuration;
use Nikolai\Php\Infrastructure\ControllerResolver\ControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use DI;
use DI\ContainerBuilder;

class Application implements ApplicationInterface
{
    public function __construct()
    {
        (new Configuration())->load();
    }

    public function run(): void
    {
        $request = Request::createFromGlobals();

        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            'Nikolai\Php\Application\Contract\EventClientInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\EventClient\RedisEventClient')
                    ->constructorParameter('host', $request->server->get('REDIS_HOST'))
                    ->constructorParameter('port', (int) $request->server->get('REDIS_PORT'))
                    ->constructorParameter('minEventPriority', (int) $request->server->get('MIN_EVENT_PRIORITY'))
                    ->constructorParameter('maxEventPriority', (int) $request->server->get('MAX_EVENT_PRIORITY')),
            'Nikolai\Php\Application\RequestConverter\RequestConverterInterface' =>
                DI\autowire('Nikolai\Php\Application\RequestConverter\RequestConverter')
                    ->methodParameter('convert', 'request', $request),
        ]);
        $container = $builder->build();

        $argv = $request->server->get('argv');
        $controllerClass = (new ControllerResolver($argv[1]))->resolve();

        $controller = $container->get($controllerClass);
        $controller($request);
    }
}
