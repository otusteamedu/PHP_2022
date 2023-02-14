<?php

namespace Ppro\Hw15\Entity\DataMapper;

class SessionMapper {

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select movie_id, hall_id from session where session_id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into session (movie_id, hall_id) values (?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update session set movie_id = ?, hall_id = ? where session_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from session where session_id = ?");
    }

    /**
     * @param int $id
     * @return Session
     */
    public function findById(int $id): ?Session
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);

        if ($result = $this->selectStmt->fetch())
            return new Session(
              $id,
              $result['movie_id'],
              $result['hall_id'],
            );
        return null;
    }

    /**
     * @param array $raw
     * @return Session
     */
    public function insert(array $raw): Session
    {
        $this->insertStmt->execute([
            $raw['movie_id'],
            $raw['hall_id'],
        ]);

        return new Session(
            (int) $this->pdo->lastInsertId(),
            $raw['movie_id'],
            $raw['hall_id'],
        );
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function update(Session $session): bool
    {
        return $this->updateStmt->execute([
            $session->getMovie(),
            $session->getHall(),
            $session->getId(),
        ]);
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function delete(Session $session): bool
    {
        return $this->deleteStmt->execute([$session->getId()]);
    }
}