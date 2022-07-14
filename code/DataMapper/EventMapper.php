<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Event;
use App\Utils\Connection;
use ArrayObject;
use Exception;
use PDO;
use PDOStatement;

class EventMapper
{
    private PDO $connection;

    private IdentityMap $identityMap;

    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $selectStatement;
    private PDOStatement $selectActiveStatement;

    private const DATETIME_FORMAT = 'Y-m-d\TH:i:s';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection->setConnection();
        $this->identityMap = new IdentityMap();

        $this->insertStatement = $this->connection->prepare(
            'INSERT INTO event (name, time_start, time_end) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $this->connection->prepare(
            'UPDATE event SET name = ?, time_start = ?, time_end = ? WHERE id = ?'
        );
        $this->deleteStatement = $this->connection->prepare(
            'DELETE FROM event WHERE id = ?'
        );
        $this->selectStatement = $this->connection->prepare(
            'SELECT * FROM event WHERE id = ?'
        );
        $this->selectActiveStatement = $this->connection->prepare(
            'SELECT * FROM event WHERE time_start <= now()::timestamp AND time_end >= now()::timestamp'
        );
    }

    /**
     * @throws Exception
     */
    public function insert(Event $event): Event
    {
        if ($this->identityMap->hasObject($event)) {
            throw new Exception('Object has an ID, cannot insert.');
        }

        $this->insertStatement->execute([
            $event->getName(),
            $event->getTimeStart()->format(self::DATETIME_FORMAT),
            $event->getTimeEnd()->format(self::DATETIME_FORMAT),
        ]);

        $id = (int)$this->connection->lastInsertId();
        $event->setId($id);

        $this->identityMap->set($id, $event);

        return $event;
    }

    /**
     * @throws Exception
     */
    public function update(Event $event): bool
    {
        if (!$this->identityMap->hasObject($event)) {
            throw new Exception('Object has no ID, cannot update.');
        }

        return $this->updateStatement->execute([
            $event->getName(),
            $event->getTimeStart()->format(self::DATETIME_FORMAT),
            $event->getTimeEnd()->format(self::DATETIME_FORMAT),
            $event->getId(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function delete(Event $event): bool
    {
        if (!$this->identityMap->hasObject($event)) {
            throw new Exception('Object has no ID, cannot delete.');
        }

        return $this->deleteStatement->execute([$event->getId()]);
    }

    /**
     * @return Event|false
     */
    public function findById(int $id): object|false
    {
        if ($this->identityMap->hasId($id)) {
            return $this->identityMap->getObject($id);
        }

        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        if ($result === false) {
            return false;
        }

        $event = new Event(
            $result['id'],
            $result['name'],
            $result['time_start'],
            $result['time_end'],
        );

        $this->identityMap->set($id, $event);

        return $event;
    }

    public function findActiveEvents(): ArrayObject
    {
        $events = new ArrayObject();

        $this->selectActiveStatement->execute();

        $results = $this->selectActiveStatement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {

            if ($this->identityMap->hasId($result['id'])) {
                $ev = $this->identityMap->getObject($result['id']);
            } else {
                $ev = new Event(
                    $result['id'],
                    $result['name'],
                    $result['time_start'],
                    $result['time_end'],
                );

                $this->identityMap->set($result['id'], $ev);
            }

            $events[$result['id']] = $ev;
        }

        return $events;
    }
}