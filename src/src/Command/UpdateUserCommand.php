<?php

declare(strict_types=1);

namespace App\Command;

use App\DataMapper\ClientMapper;
use App\Entity\Client;
use PDO;

class UpdateUserCommand implements CommandInterface
{
    private Client $client;
    private bool $result = false;

    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $pdo = new PDO($this->config['database']['dsn']);
        $clientMapper = new ClientMapper($pdo);
        $this->client = $clientMapper->findById((int)$this->params[0]);
        $this->client->setEmail($this->params[1]);
        $this->client->setPhone($this->params[2] ?? '');
        $this->result = $clientMapper->update($this->client);
    }

    public function printResult(): void
    {
        if ($this->result) {
            printf(
                "Client id %d success updated: e-mail %s, phone %s\n",
                $this->client->getId(),
                $this->client->getEmail(),
                $this->client->getPhone()
            );
        } else {
            printf("Error while updating client id %d\n", $this->client->getId());
        }
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
