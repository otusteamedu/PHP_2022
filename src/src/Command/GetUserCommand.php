<?php

declare(strict_types=1);

namespace App\Command;

use App\DataMapper\ClientMapper;
use App\Entity\Client;
use PDO;

class GetUserCommand implements CommandInterface
{
    private Client $client;

    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $pdo = new PDO($this->config['database']['dsn']);
        $clientMapper = new ClientMapper($pdo);
        $this->client = $clientMapper->findById((int)$this->params[0]);
    }

    public function printResult(): void
    {
        printf(
            "Client id %d e-mail: %s  phone:%s\n",
            $this->client->getId(),
            $this->client->getEmail(),
            $this->client->getPhone()
        );
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
