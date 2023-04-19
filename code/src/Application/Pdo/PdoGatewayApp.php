<?php

namespace Svatel\Code\Application\Pdo;

use PDO;
use Svatel\Code\Domain\Config\Config;
use Svatel\Code\Domain\Pdo\PdoDomainInterface;
use Svatel\Code\Infrastructure\Gateway\PdoGatewayInterface;

final class PdoGatewayApp implements PdoGatewayInterface, PdoDomainInterface
{
    private Config $config;
    private PDO $client;

    public function __construct()
    {
        $this->config = new Config();
        $this->client = new PDO(
            'mysql:host=host.docker.internal;dbname=' . $this->config->getForName('db_name'),
            $this->config->getForName('db_user'),
            $this->config->getForName('db_password')
        );
    }

    public function getClient(): PDO
    {
        return $this->client;
    }
}
