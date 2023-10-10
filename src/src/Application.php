<?php

declare(strict_types=1);

namespace App;

use App\Command\CommandInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

final class Application
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws RuntimeException|NotFoundExceptionInterface|ContainerExceptionInterface
     */
    public function run(): void
    {
        $command = $this->getCommand();

        $command->execute();
    }

    /**
     * @throws RuntimeException|NotFoundExceptionInterface|ContainerExceptionInterface
     */
    private function getCommand(): CommandInterface
    {
        if (!isset($_SERVER['argv'])) {
            throw new RuntimeException(
                "Error! Make sure the 'register_argc_argv' param in your php.ini is set to 1"
            );
        }
        $commandName = $_SERVER['argv'][1] ?? $this->container->get('config')['defaultCommandName'];
        return $this->container->get('commands')[$commandName];
    }
}
