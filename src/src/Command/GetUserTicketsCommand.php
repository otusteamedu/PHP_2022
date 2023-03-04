<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Client;

class GetUserTicketsCommand implements CommandInterface
{
    private Client $client;

    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $command = new GetUserCommand($this->config, $this->params);
        $command->execute();
        $this->client = $command->getClient();
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
