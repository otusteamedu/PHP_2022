<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Command\AbstractCommand;
use Dkozlov\Otus\Command\LoadBookCommand;
use Dkozlov\Otus\Command\SearchBookCommand;
use Dkozlov\Otus\Exception\CommandNotFoundException;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\QueryBuilder\SearchBookQueryBuilder;
use Dkozlov\Otus\Repository\ElasticSearchRepository;
use Dkozlov\Otus\Repository\Interface\RepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use PDO;

class Application
{

    private static Config $config;

    private array $depencies;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(
        private readonly array $argv
    ) {
        self::$config = new Config(__DIR__ . '/../config/config.ini');

        $this->depencies = require('../app/depencies.php');
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
    private function getCommand(string $commandName): AbstractCommand
    {
        return match($commandName) {
            'load' => new LoadBookCommand($this->depencies[RepositoryInterface::class], $this->argv),
            'search' => new SearchBookCommand($this->depencies[RepositoryInterface::class], $this->argv),
            default => throw new CommandNotFoundException("Command \"$commandName\" not found")
        };
    }
}