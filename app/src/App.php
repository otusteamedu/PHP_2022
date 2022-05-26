<?php

namespace Nka\OtusSocketChat;

use DI\Container;
use DI\ContainerBuilder;
use Nka\OtusSocketChat\Commands\ClientCommand;
use Nka\OtusSocketChat\Commands\ServerCommand;
use Nka\OtusSocketChat\Services\SocketClientService;
use Nka\OtusSocketChat\Services\SocketServerService;
use function DI\create;
use function DI\factory;
use function DI\get;

class App
{
    public function __construct(
        public CommandResolver $commandResolver
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        return $this->commandResolver->validate()->resolve();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function init(): self
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::setDefinitions());
        return $builder->build()->get(self::class);
    }

    /**
     * Описываем зависимости приложение
     * @return array
     */
    private static function setDefinitions(): array
    {
        return [
            self::class => create()
                ->constructor(get(CommandResolver::class)),
            CommandResolver::class => factory(function (Container $container) {
                return new CommandResolver($container);
            }),
            ClientCommand::class => create()
                ->constructor(get(SocketClientService::class)),
            ServerCommand::class => create()
                ->constructor(get(SocketServerService::class)),
            SocketClientService::class => create()
                ->constructor(
                    create(Socket::class)
                        ->constructor(get('SOCKET_ADR'), false)
                ),
            SocketServerService::class => create()
                ->constructor(
                    create(Socket::class)
                        ->constructor(get('SOCKET_ADR'))
                ),
            'SOCKET_ADR' => getenv('SOCKET_ADR'),
        ];
    }

}
