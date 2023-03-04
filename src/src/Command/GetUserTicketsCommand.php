<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Client;
use App\Storage\StorageInterface;

class GetUserTicketsCommand implements CommandInterface
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
        printf("Client id %d e-mail: %s\n", $this->client->getId(), $this->client->getEmail());
        printf("Found %d tickets:\n", count($this->client->getTickets()));
        foreach ($this->client->getTickets() as $ticket) {
            printf(
                "Price:%d Place:%d PurchaceTime:%s\n",
                $ticket->getPrice(),
                $ticket->getPlace(),
                $ticket->getPurchaseTime()
            );
        }
    }
}
