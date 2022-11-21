<?php

declare(strict_types=1);

namespace App\Domain\Repository\Mappers;

use App\Domain\Repository\IdentityMap;
use App\Domain\Repository\Entities\Ticket;
use App\Domain\Contracts\Database\DataBaseConnectionContract;

final class TicketMapper
{
    private const TABLE_NAME = 'ticket';

    /**
     * @var \PDO
     */
    private \PDO $db_connection;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $select;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $selectAll;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $insert;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $update;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $delete;

    /**
     * @var IdentityMap
     */
    private IdentityMap $identity_map;

    /**
     * @param DataBaseConnectionContract $db_connector
     */
    public function __construct(DataBaseConnectionContract $db_connector)
    {
        $this->identity_map = new IdentityMap();

        $this->db_connection = $db_connector->pdoConnector();

        $this->select = $this->db_connection->prepare(
            query: 'SELECT date_of_sale, time_of_sale, customer_id, schedule_id, total_price, movie_name FROM '
            . self::TABLE_NAME . ' WHERE id = ?'
        );

        $this->selectAll = $this->db_connection->prepare(query: 'SELECT * FROM ' . self::TABLE_NAME);

        $this->insert = $this->db_connection->prepare(
            query: 'INSERT INTO ' . self::TABLE_NAME . ' '
            . '(date_of_sale, time_of_sale, customer_id, schedule_id, total_price, movie_name) '
            . 'VALUES (?, ?, ?, ?, ?, ?)'
        );

        $this->update = $this->db_connection->prepare(
            query: 'UPDATE ' . self::TABLE_NAME . ' '
            . 'SET date_of_sale=?, time_of_sale=?, customer_id=?, schedule_id=?, total_price=?, movie_name=? WHERE id=?'
        );

        $this->delete = $this->db_connection->prepare(query: 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = ?');
    }

    /**
     * @param int $id
     * @return object
     */
    public function findById(int $id): object
    {
        if ($this->identity_map->hasId($id)) {
            return $this->identity_map->getObject(id: $id);
        }

        $this->select->setFetchMode(mode: \PDO::FETCH_ASSOC);
        $this->select->execute(params:[$id]);

        $result = $this->select->fetch();

        return new Ticket(
            id: $id,
            date_of_sale: $result['date_of_sale'],
            time_of_sale: $result['time_of_sale'],
            customer_id: $result['customer_id'],
            schedule_id: $result['schedule_id'],
            total_price: $result['total_price'],
            movie_name: $result['movie_name'],
        );
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $this->selectAll->setFetchMode(mode: \PDO::FETCH_ASSOC);
        $this->selectAll->execute(params:[]);

        $results = $this->selectAll->fetchAll();

        $finally_results = [];
        foreach ($results as $result) {
            $finally_results[] = new Ticket(
                id: $result['id'],
                date_of_sale: $result['date_of_sale'],
                time_of_sale: $result['time_of_sale'],
                customer_id: $result['customer_id'],
                schedule_id: $result['schedule_id'],
                total_price: $result['total_price'],
                movie_name: $result['movie_name'],
            );
        }

        return $finally_results;
    }

    /**
     * @param Ticket $ticket
     * @return Ticket
     * @throws \Exception
     */
    public function insert(Ticket $ticket): Ticket
    {
        if ($this->identity_map->hasObject($ticket)) {
            throw new \Exception(message: 'Ticket with this ID cannot be inserted');
        }

        $date_of_sale = $ticket->getDateOfSale();
        $time_of_sale = $ticket->getTimeOfSale();
        $customer_id = $ticket->getCustomerId();
        $schedule_id = $ticket->getScheduleId();
        $total_price = $ticket->getTotalPrice();
        $movie_name = $ticket->getMovieName();

        $this->insert->execute(params: [
            $date_of_sale,
            $time_of_sale,
            $customer_id,
            $schedule_id,
            $total_price,
            $movie_name,
        ]);

        return new Ticket(
            id: (int) $this->db_connection->lastInsertId(),
            date_of_sale: $date_of_sale,
            time_of_sale: $time_of_sale,
            customer_id: $customer_id,
            schedule_id: $schedule_id,
            total_price: $total_price,
            movie_name: $movie_name
        );
    }

    /**
     * @param object $ticket
     * @return bool
     * @throws \Exception
     */
    public function update(object $ticket): bool
    {
        if ($this->identity_map->hasObject($ticket)) {
            throw new \Exception(message: 'Ticket with this ID cannot be updated');
        }

        return $this->update->execute(params: [
            $ticket->getDateOfSale(),
            $ticket->getTimeOfSale(),
            $ticket->getCustomerId(),
            $ticket->getScheduleId(),
            $ticket->getTotalPrice(),
            $ticket->getMovieName(),
            $ticket->getId(),
        ]);
    }

    /**
     * @param object $ticket
     * @return bool
     * @throws \Exception
     */
    public function delete(object $ticket): bool
    {
        if ($this->identity_map->hasObject($ticket)) {
            throw new \Exception(message: 'Ticket with this ID cannot be deleted');
        }

        return $this->delete->execute(params: [$ticket->getId()]);
    }
}
