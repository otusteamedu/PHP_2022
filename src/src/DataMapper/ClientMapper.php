<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Client;
use App\Entity\Ticket;
use PDO;
use PDOStatement;
use RuntimeException;

class ClientMapper
{
    private PDOStatement $selectStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $deleteStmt;

    private PDOStatement $selectTicketsStmt;

    public function __construct(PDO $pdo)
    {
        $this->selectStmt = $pdo->prepare(
            "SELECT \"E-mail\", \"Phone\" FROM" . " \"Client\" WHERE id = ?"
        );
        $this->selectTicketsStmt = $pdo->prepare(
            "SELECT id, \"Price\", \"Place\", \"Schedule\", \"PurchaseTime\" FROM" . " \"Ticket\" WHERE \"Client\" = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "INSERT INTO" . " \"Client\" (id, \"E-mail\", \"Phone\") VALUES (?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "UPDATE" . " \"Client\" SET \"E-mail\" = ?, \"Phone\" = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("DELETE FROM" . " \"Client\" WHERE id = ?");
    }

    public function findById(int $id): Client
    {
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($result)) {
            throw new RuntimeException('Client not found');
        }

        $client = new Client(
            $id,
            $result['E-mail'],
            $result['Phone']
        );

        $reference = function () use ($id) {
            $this->selectTicketsStmt->execute([$id]);
            $result = $this->selectTicketsStmt->fetchAll(PDO::FETCH_ASSOC);
            $tickets = [];

            foreach ($result as $data) {
                $tickets[] = new Ticket(
                    $data['id'],
                    $data['Schedule'],
                    $data['Price'],
                    $id,
                    $data['Place'],
                    $data['PurchaseTime']
                );
            }
            return $tickets;
        };

        $client->setReference($reference);
        return $client;
    }

    public function insert(array $raw): Client
    {
        $this->insertStmt->execute([
            $raw['id'],
            $raw['email'],
            $raw['phone']
        ]);

        return new Client(
            $raw['id'],
            $raw['email'],
            $raw['phone']
        );
    }

    public function update(Client $client): bool
    {
        return $this->updateStmt->execute([
            $client->getEmail(),
            $client->getPhone()
        ]);
    }

    public function delete(Client $client): bool
    {
        return $this->deleteStmt->execute([$client->getId()]);
    }
}
