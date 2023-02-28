<?php

declare(strict_types=1);

namespace App\Command;

use App\DataMapper\ClientMapper;

class GetUserCommand implements CommandInterface
{
    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $pdo = new \PDO($this->config['database']['dsn']);
        $clientMapper = new ClientMapper($pdo);
        $client = $clientMapper->findById((int)$this->params[0]);
        printf("Client id %d e-mail: %s\n", $client->getId(), $client->getEmail());
    }
}
