<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure;

use Nikolai\Php\Domain\Service\ServiceManager;
use Nikolai\Php\Infrastructure\Configuration\Configuration;
use Nikolai\Php\Infrastructure\ControllerResolver\ControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use DI;
use DI\ContainerBuilder;

class Application implements ApplicationInterface
{
    public function run(): void
    {
        $mapping = (new Configuration())->load();
        $request = Request::createFromGlobals();

        $builder = new ContainerBuilder();
        $builder->addDefinitions([
/*
            'PDO' => DI\autowire('PDO')
                ->constructorParameter('dsn', $request->server->get('DB_DSN')),
*/
            'Nikolai\Php\Domain\Mapper\MapperInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\Mapper')
                    ->constructorParameter('mapping', $mapping),
/*
            'Nikolai\Php\Domain\Collection\LazyLoadCollection' =>
                DI\autowire()
                    ->methodParameter('doInitialize', 'mapper', $request),
*/

/*
            'Nikolai\Php\Application\Contract\EventClientInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\EventClient\RedisEventClient')
                    ->constructorParameter('host', $request->server->get('REDIS_HOST'))
                    ->constructorParameter('port', (int) $request->server->get('REDIS_PORT'))
                    ->constructorParameter('minEventPriority', (int) $request->server->get('MIN_EVENT_PRIORITY'))
                    ->constructorParameter('maxEventPriority', (int) $request->server->get('MAX_EVENT_PRIORITY')),
            'Nikolai\Php\Application\RequestConverter\RequestConverterInterface' =>
                DI\autowire('Nikolai\Php\Application\RequestConverter\RequestConverter')
                    ->methodParameter('convert', 'request', $request),
*/
        ]);
        $container = $builder->build();

        ServiceManager::setMapper($container->get('Nikolai\Php\Domain\Mapper\MapperInterface'));

        $argv = $request->server->get('argv');
        $controllerClass = (new ControllerResolver($argv[1]))->resolve();

        $controller = $container->get($controllerClass);
        $controller($request);
    }
}
