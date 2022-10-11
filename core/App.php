<?php

namespace Otus\Core;

use DI\Container;
use Otus\Core\Command\CommandInterface;
use Otus\Core\Config\AbstractConfig;
use DI\ContainerBuilder;
use Otus\Core\Request\CliRequest;
use RuntimeException;

class App
{
    private Container $container;
    private string $di = __DIR__ . '/../di.php';
    private AbstractConfig $config;

    private function __construct()
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->addDefinitions($this->di)->build();
        $this->config = $this->container->get(AbstractConfig::class);
    }

    public static function run()
    {
        $instance = new App ();
        $instance->handleRequest();
    }

    private function handleRequest(): void
    {
        $request = $this->container->get(CliRequest::class);
        $request->init();
        $command = $this->getCommand($request);
        $command->execute();
    }

    public function getCommand(CliRequest $request): CommandInterface
    {
        $commandName = $request->getCommandName();
        if (is_null($commandName)) {
            throw new RuntimeException("Invalid command name");
        }
        $commands = $this->config->get('commands');
        if (!array_key_exists($commandName, $commands)) {
            throw new RuntimeException("The command $commandName not found");
        }
        return $this->container->get($commands[$commandName]);
    }
}