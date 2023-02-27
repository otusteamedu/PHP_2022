<?php

declare(strict_types=1);

namespace Eliasj\Hw16\App\Kernel\Configs;

use Dotenv\Dotenv;
use Eliasj\Hw16\App\Exceptions\NoAttributeException;
use Eliasj\Hw16\App\Kernel\Singleton;

class RabbitConfig
{
    use Singleton;

    private string $user;
    private string $pass;

    public function load(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../../');
        $dotenv->load();

        $this->user = $_ENV['RABBITMQ_USER'];
        $this->pass = $_ENV['RABBITMQ_PASSWORD'];
    }

    /**
     * @throws NoAttributeException
     */
    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new NoAttributeException($name);
        }
        return $this->$name;
    }
}
