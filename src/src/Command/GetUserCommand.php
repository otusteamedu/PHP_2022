<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Client;
use App\Storage\StorageInterface;

class GetUserCommand implements CommandInterface
{
    private Client $client;

    public function __construct(private StorageInterface $storage, private array $params)
    {
    }

    public function execute(): void
    {
        $clientRepository = $this->storage->getClientRepository();
        $this->client = $clientRepository->findOne((int)$this->params[0]);
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
