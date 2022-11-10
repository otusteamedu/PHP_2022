<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Container;

use Nikolai\Php\Infrastructure\Dispatcher\ListenerProvider;
use Psr\EventDispatcher\ListenerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use DI;
//use DI\ContainerBuilder;

class ContainerBuilder implements ContainerBuilderInterface
{
    public function __construct(private Request $request, private array $configuration) {}

    public function build(): Container
    {
        $builder = new \DI\ContainerBuilder();
        $builder->useAnnotations(true);

        $listenerProvider = $this->getListenerProvider();

        $builder->addDefinitions([
            'configuration' => DI\value($this->configuration),
            'Psr\EventDispatcher\EventDispatcherInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Dispatcher\EventDispatcher')
                    ->constructorParameter('listenerProvider', $listenerProvider),
            'Nikolai\Php\Domain\Factory\FactoryDishFactoryInterface' =>
                DI\autowire('Nikolai\Php\Application\Factory\FactoryDishFactory'),
            'Nikolai\Php\Domain\Factory\DecorateFactoryInterface' =>
                DI\autowire('Nikolai\Php\Application\Factory\DecorateFactory'),

/*
            'PDO' => DI\autowire('PDO')
                ->constructorParameter('dsn', Connection::getInstance()->getConnection()),
            'Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilderFactoryInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilderFactory'),
            'Nikolai\Php\Infrastructure\Mapper\MappingConfiguratorInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\MappingConfigurator')
                    ->constructorParameter('mapping', $mapping),
            'Nikolai\Php\Infrastructure\Mapper\EntityObjectBuilderInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\EntityObjectBuilder'),
            'Nikolai\Php\Domain\Mapper\MapperInterface' =>
                DI\autowire('Nikolai\Php\Infrastructure\Mapper\Mapper'),
*/
        ]);



        $container = $builder->build();

        return new Container($container);
    }

    private function getListenerProvider(): ListenerProviderInterface
    {
        $listenerProvider = new ListenerProvider();
        foreach ($this->configuration['listeners'] as $listener => $event) {
            $listenerProvider->addListener($event['event'], new $listener());

        }

//        var_dump($listenerProvider);

        return $listenerProvider;
    }
}