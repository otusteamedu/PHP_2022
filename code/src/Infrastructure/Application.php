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
            'PDO' => DI\autowire('PDO')
                ->constructorParameter('dsn', $request->server->get('DB_DSN')),
            'Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilderFactoryInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilderFactory'),
            'Nikolai\Php\Infrastructure\Mapper\MappingConfiguratorInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\MappingConfigurator')
                    ->constructorParameter('mapping', $mapping),
            'Nikolai\Php\Infrastructure\Mapper\EntityObjectBuilderInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\EntityObjectBuilder'),
            'Nikolai\Php\Domain\Mapper\MapperInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\Mapper'),
        ]);
        $container = $builder->build();

        ServiceManager::setMapper($container->get('Nikolai\Php\Domain\Mapper\MapperInterface'));

        $argv = $request->server->get('argv');
        $controllerClass = (new ControllerResolver($argv[1]))->resolve();

        $controller = $container->get($controllerClass);
        $controller($request);
    }
}
