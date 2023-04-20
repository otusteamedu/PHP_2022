<?php

namespace Svatel\Code\Application\Pdo;

use PDO;
use Svatel\Code\Domain\Config\Config;
use Svatel\Code\Domain\Pdo\PdoDomainInterface;
use Svatel\Code\Infrastructure\Gateway\PdoGatewayInterface;

final class PdoGatewayApp implements PdoGatewayInterface, PdoDomainInterface
{
    private Config $config;
    private ?PDO $client = null;

    public function __construct()
    {
        $this->config = new Config();

        $dbUser = $this->config->getForName('db_user');
        $dbPassword = $this->config->getForName('db_password');

        if (!empty($dbUser) && !empty($dbPassword)) {
            $this->client = new PDO(
                'mysql:host=host.docker.internal;dbname=' . $this->config->getForName('db_name'),
                $dbUser,
                $dbPassword
            );
        }
    }

    public function getClient(): ?PDO
    {
        return $this->client;
    }
}
