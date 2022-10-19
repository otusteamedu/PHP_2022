<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Nikolai\Php\Domain\Entity\CinemaHall;
use PDO;

class CinemaHallMapper
{
    const INSERT_STATEMENT = 'insert into cinema_hall (name) values (?)';
    const UPDATE_STATEMENT = 'update cinema_hall set name = ? where id = ?';
    const DELETE_STATEMENT = 'delete from cinema_hall where id = ?';

    public function __construct(private PDO $pdo) {}

    public function insert(CinemaHall $entity): CinemaHall
    {
        $statement = $this->pdo->prepare(self::INSERT_STATEMENT);
        $statement->execute([$entity->getName()]);

        $entity->setId((int) $this->pdo->lastInsertId());
        return $entity;
    }

    public function update(CinemaHall $entity): CinemaHall
    {
        $statement = $this->pdo->prepare(self::UPDATE_STATEMENT);
        $statement->execute([$entity->getName()]);

        return $entity;
    }

    public function delete(CinemaHall $entity): bool
    {
        $statement = $this->pdo->prepare(self::DELETE_STATEMENT);
        $statement->execute([$entity->getId()]);

        return true;
    }
}