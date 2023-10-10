<?php

declare(strict_types=1);

namespace App\Application\App;

use App\Application\Command\CommandInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class Application implements ApplicationInterface
{
    public function __construct(public readonly ContainerInterface $container)
    {
    }

    /**
     * @throws NotFoundExceptionInterface|ContainerExceptionInterface
     */
    public function run(): void
    {
        $command = $this->getCommand();

        $command->execute();
    }

    /**
     * @throws NotFoundExceptionInterface|ContainerExceptionInterface
     */
    public function getCommand(): CommandInterface
    {
        return $this->container->get('commands')[$this->getCommandName()];
    }

    abstract protected function getCommandName(): string;
}
