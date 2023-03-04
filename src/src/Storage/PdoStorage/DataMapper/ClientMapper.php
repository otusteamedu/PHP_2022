<?php

declare(strict_types=1);

namespace App\Storage\PdoStorage\DataMapper;

use App\Entity\Client;
use App\Entity\Ticket;
use App\DataMapper\AbstractDataMapper;
use PDO;
use PDOStatement;
use RuntimeException;

class ClientMapper extends AbstractDataMapper
{
    private PDOStatement $selectStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $deleteStmt;

    private PDOStatement $selectTicketsStmt;

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            'SELECT "E-mail", "Phone" FROM "Client" WHERE id = ?'
        );
        $this->selectTicketsStmt = $pdo->prepare(
            'SELECT id, "Price", "Place", "Schedule", "PurchaseTime" FROM "Ticket" WHERE "Client" = ?'
        );

        $this->insertStmt = $pdo->prepare(
            'INSERT INTO "Client" (id, "E-mail", "Phone") VALUES (?, ?, ?)'
        );
        $this->deleteStmt = $pdo->prepare('DELETE FROM "Client" WHERE id = ?');
    }

    public function findOne(int $id): Client
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

        $client->setState([
            'E-mail' => $result['E-mail'],
            'Phone' => $result['Phone']
        ]);

        $reference =
            /**
             * @return Ticket[]
             */
            function () use ($id) {
                $this->selectTicketsStmt->execute([$id]);
                $result = $this->selectTicketsStmt->fetchAll(PDO::FETCH_ASSOC);
                $tickets = [];

                /**
                 * @var array $data
                 */
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
        $clientState = $client->getState();

        /**
         * @TODO think about returning val
         */
        if ($clientState['E-mail'] === $client->getEmail() && $clientState['Phone'] === $client->getPhone()) {
            return true;
        }

        $query = 'UPDATE "Client" SET "E-mail" = ?, "Phone" = ? where id = ?';
        $params = [
            $client->getEmail(),
            $client->getPhone(),
            $client->getId()
        ];

        if ($clientState['E-mail'] !== $client->getEmail() && $clientState['Phone'] === $client->getPhone()) {
            $query = 'UPDATE "Client" SET "E-mail" = ? where id = ?';
            $params = [$client->getEmail(), $client->getId()];
        }

        if ($clientState['E-mail'] === $client->getEmail() && $clientState['Phone'] !== $client->getPhone()) {
            $query = 'UPDATE "Client" SET "Phone" = ? where id = ?';
            $params = [$client->getPhone(), $client->getId()];
        }

        return $this->pdo->prepare($query)->execute($params);
    }

    public function delete(Client $client): bool
    {
        return $this->deleteStmt->execute([$client->getId()]);
    }
}
