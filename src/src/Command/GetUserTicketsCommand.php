<?php

declare(strict_types=1);

namespace App\Command;

use App\DataMapper\ClientMapper;
use App\Entity\Ticket;

class GetUserTicketsCommand implements CommandInterface
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
        printf("Found %d tickets:\n", count($client->getTickets()));
        foreach ($client->getTickets() as $ticket) {
            printf(
                "Price:%d Place:%d PurchaceTime:%s\n",
                $ticket->getPrice(),
                $ticket->getPlace(),
                $ticket->getPurchaseTime()
            );
        }
    }
}
