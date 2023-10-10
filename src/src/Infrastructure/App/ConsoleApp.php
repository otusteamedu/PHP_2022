<?php

declare(strict_types=1);

namespace App\Infrastructure\App;

use App\Application\App\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

final class ConsoleApp extends Application
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getCommandName(): string
    {
        if (!isset($_SERVER['argv'])) {
            throw new RuntimeException(
                "Error! Make sure the 'register_argc_argv' param in your php.ini is set to 1"
            );
        }
        return $_SERVER['argv'][1] ?? $this->container->get('config')['defaultCommandName'];
    }
}
