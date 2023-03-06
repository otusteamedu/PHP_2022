<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Client;
use App\Storage\StorageInterface;

class UpdateUserCommand implements CommandInterface
{
    private ?Client $client = null;
    private bool $result = false;

    public function __construct(private StorageInterface $storage, private array $params)
    {
    }

    public function execute(): void
    {
        $clientRepository = $this->storage->getClientRepository();
        $client = $clientRepository->findOne((int)$this->params[0]);
        $client->setEmail((string)$this->params[1]);
        $client->setPhone((string)$this->params[2]);
        $this->setResult($clientRepository->update($client));
        $this->setClient($client);
    }

    public function printResult(): void
    {
        if (!isset($this->client)) {
            echo 'Client not found';
            return;
        }

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

    private function setClient(Client $client): void
    {
        $this->client = $client;
    }

    private function setResult(bool $result): void
    {
        $this->result = $result;
    }
}
