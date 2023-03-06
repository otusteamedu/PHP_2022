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
            'SELECT email, phone FROM client WHERE id = ?'
        );
        $this->selectTicketsStmt = $pdo->prepare(
            'SELECT id, price, place, schedule, purchase_time FROM ticket WHERE client = ?'
        );

        $this->insertStmt = $pdo->prepare(
            'INSERT INTO client (id, email, phone) VALUES (?, ?, ?)'
        );
        $this->deleteStmt = $pdo->prepare('DELETE FROM client WHERE id = ?');
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
            $result['email'],
            $result['phone']
        );

        $client->setState([
            'email' => $result['email'],
            'phone' => $result['phone']
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
                        $data['schedule'],
                        $data['price'],
                        $id,
                        $data['place'],
                        $data['purchase_time']
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
        if ($clientState['email'] === $client->getEmail() && $clientState['phone'] === $client->getPhone()) {
            return true;
        }

        $query = 'UPDATE client SET email = ?, phone = ? where id = ?';
        $params = [
            $client->getEmail(),
            $client->getPhone(),
            $client->getId()
        ];

        if ($clientState['email'] !== $client->getEmail() && $clientState['phone'] === $client->getPhone()) {
            $query = 'UPDATE client SET email = ? where id = ?';
            $params = [$client->getEmail(), $client->getId()];
        }

        if ($clientState['email'] === $client->getEmail() && $clientState['phone'] !== $client->getPhone()) {
            $query = 'UPDATE client SET phone = ? where id = ?';
            $params = [$client->getPhone(), $client->getId()];
        }

        return $this->pdo->prepare($query)->execute($params);
    }

    public function delete(Client $client): bool
    {
        return $this->deleteStmt->execute([$client->getId()]);
    }
}
