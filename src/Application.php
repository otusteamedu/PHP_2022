<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Infrastructure\Command\Exception\CommandNotFoundException;
use Dkozlov\Otus\Infrastructure\Command\Interface\CommandInterface;
use Dkozlov\Otus\Infrastructure\Command\LoadBookCommand;
use Dkozlov\Otus\Infrastructure\Command\SearchBookCommand;
use Exception;

class Application
{

    private static Config $config;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(
        private readonly array $argv
    ) {
        self::$config = new Config(__DIR__ . '/../config/config.ini');
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $command = $this->getCommand($this->argv[1] ?? '');

        $command->execute();
    }

    public static function config(string $name): mixed
    {
        return self::$config->get($name);
    }

    /**
     * @throws Exception
     */
    private function getCommand(string $commandName): CommandInterface
    {
        return match($commandName) {
            'load' => new LoadBookCommand(
                self::$config->depency(RepositoryInterface::class),
                $this->argv
            ),
            'search' => new SearchBookCommand(
                self::$config->depency(RepositoryInterface::class),
                $this->argv
            ),
            default => throw new CommandNotFoundException("Command \"$commandName\" not found")
        };
    }
}