<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Map\Ticket;

use PDO;
use PDOStatement;
use Nikcrazy37\Hw12\Map\EntityMapper;
use Nikcrazy37\Hw12\Map\Entity;
use Nikcrazy37\Hw12\Exception\NotFoundElementException;
use Nikcrazy37\Hw12\Map\IdentityMap;

class TicketMapper implements EntityMapper
{
    const TABLE_NAME = "ticket";

    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @var PDOStatement
     */
    private PDOStatement $selectStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $selectAllStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $insertStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $updateStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $deleteStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $countStmt;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select price, seat, session_id from " . self::TABLE_NAME . " where id = ?"
        );

        $this->selectAllStmt = $pdo->prepare("select * from " . self::TABLE_NAME);

        $this->insertStmt = $pdo->prepare(
            "insert into " . self::TABLE_NAME . " (price, seat, session_id) values (?, ?, ?)"
        );

        $this->updateStmt = $pdo->prepare(
            "update " . self::TABLE_NAME . " set price = ?, seat = ?, session_id = ? where id = ?"
        );

        $this->deleteStmt = $pdo->prepare("delete from " . self::TABLE_NAME . " where id = ?");

        $this->countStmt = $pdo->prepare("select count(*) from " . self::TABLE_NAME);
    }

    /**
     * @param int $id
     * @return Ticket
     * @throws NotFoundElementException
     */
    public function findById(int $id): Ticket
    {
        $cache = $this->getFromMap($id);

        if (!is_null($cache)) {
            return $cache;
        }

        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute(array($id));

        if (!$result = $this->selectStmt->fetch()) {
            throw new NotFoundElementException($id);
        }

        $ticket = new Ticket(
            $id,
            $result['price'],
            $result['seat'],
            $result['session_id'],
        );

        $this->addToMap($ticket);

        return $ticket;
    }

    public function getAll(): TicketCollection
    {
        $this->countStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->countStmt->execute();
        $dbCount = $this->countStmt->fetch();

        $ticketCollection = new TicketCollection();
        $collectionCount = $ticketCollection->getCount();

        if ($dbCount > $collectionCount) {
            $this->selectAllStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectAllStmt->execute();
            $result = $this->selectAllStmt->fetchAll();

            array_walk($result, function ($element) {
                $this->addToMap(
                    new Ticket(
                        $element["id"],
                        $element["price"],
                        $element["seat"],
                        $element["session_id"],
                    )
                );
            });
        }

        return new TicketCollection();
    }

    /**
     * @param array $row
     * @return Ticket
     */
    public function insert(array $row): Ticket
    {
        $this->insertStmt->execute(
            array(
                $row['price'],
                $row['seat'],
                $row['session_id'],
            )
        );

        $ticket = new Ticket(
            (int)$this->pdo->lastInsertId(),
            $row['price'],
            $row['seat'],
            $row['session_id'],
        );

        $this->addToMap($ticket);

        return $ticket;
    }

    /**
     * @param Entity $ticket
     * @return bool
     */
    public function update(Entity $ticket): bool
    {
        $this->addToMap($ticket);

        return $this->updateStmt->execute(
            array(
                $ticket->getPrice(),
                $ticket->getSeat(),
                $ticket->getSessionId(),
                $ticket->getId(),
            )
        );
    }

    /**
     * @param Entity $ticket
     * @return bool
     */
    public function delete(Entity $ticket): bool
    {
        return $this->deleteStmt->execute(
            array($ticket->getId())
        );
    }

    /**
     * @param $id
     * @return Ticket|null
     */
    public function getFromMap($id): ? Ticket
    {
        return IdentityMap::exist(get_class(), $id);
    }

    /**
     * @param Entity $obj
     * @return void
     */
    public function addToMap(Entity $obj): void
    {
        IdentityMap::add($obj);
    }
}