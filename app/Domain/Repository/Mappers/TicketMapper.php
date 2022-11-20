<?php

declare(strict_types=1);

namespace App\Domain\Repository\Mappers;

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
     * @param DataBaseConnectionContract $db_connector
     */
    public function __construct(DataBaseConnectionContract $db_connector)
    {
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
     * @return Ticket
     */
    public function findById(int $id): Ticket
    {
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
     * @param array $raw_data
     * @return Ticket
     */
    public function insert(array $raw_data): Ticket
    {
        $this->insert->execute(params: [
            $raw_data['date_of_sale'],
            $raw_data['time_of_sale'],
            $raw_data['customer_id'],
            $raw_data['schedule_id'],
            $raw_data['total_price'],
            $raw_data['movie_name'],
        ]);

        return new Ticket(
            id: (int) $this->db_connection->lastInsertId(),
            date_of_sale: $raw_data['date_of_sale'],
            time_of_sale: $raw_data['time_of_sale'],
            customer_id: $raw_data['customer_id'],
            schedule_id: $raw_data['schedule_id'],
            total_price: $raw_data['total_price'],
            movie_name: $raw_data['movie_name']
        );
    }

    /**
     * @param Ticket $ticket
     * @return bool
     */
    public function update(Ticket $ticket): bool
    {
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
     * @param int $ticket_id
     * @return bool
     */
    public function delete(int $ticket_id): bool
    {
        return $this->delete->execute(params: [$ticket_id]);
    }
}
