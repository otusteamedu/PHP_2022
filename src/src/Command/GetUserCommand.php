<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Client;
use App\Storage\StorageInterface;

class GetUserCommand implements CommandInterface
{
    private ?Client $client = null;
    private int $clientId;

    public function __construct(private StorageInterface $storage, array $params)
    {
        $this->clientId = (int)$params[0];
    }

    public function execute(): void
    {
        $clientRepository = $this->storage->getClientRepository();
        $this->setClient($clientRepository->findOne($this->clientId));
    }

    public function printResult(): void
    {
        if (!isset($this->client)) {
            echo 'Client not found';
            return;
        }
        printf(
            "Client id %d e-mail: %s  phone:%s\n",
            $this->client->getId(),
            $this->client->getEmail(),
            $this->client->getPhone()
        );
    }

    private function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
