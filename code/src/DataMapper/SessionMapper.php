<?php

declare(strict_types = 1);

namespace Study\Cinema\DataMapper;

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
     * @var IdentityMap
     */
    private IdentityMap $identity_map;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->identity_map = new IdentityMap();


        $this->selectStmt = $pdo->prepare(
            "select hall_id, movie_id, days_type_id, price, started_at from session where session_id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into session(hall_id, movie_id, days_type_id, price, started_at, created_at, updated_at) values (?, ?, ?, ?, ?, now(),now())"
        );
        $this->updateStmt = $pdo->prepare(
            "update session set hall_id = ?, movie_id = ?, days_type_id = ?,  price = ?, started_at = ?, updated_at = now() where session_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from session where session_id = ?");
    }


    public function findById(int $id): Session
    {
        if ($this->identity_map->exists(Session::class, $id)) {
            return $this->identity_map->get(Session::class, $id);
        }
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Session(
            $id,
            $result['hall_id'],
            $result['movie_id'],
            $result['days_type_id'],
            $result['price'],
            $result['started_at'],

        );
    }

    public function insert(Session $session): Session|false
    {

        if($this->insertStmt->execute([$session->getHallId(),$session->getMovieId(),$session->getDaysTypeId(),
                                       $session->getPrice(), $session->getStartedAt()]))
        {
            $sessionId = (int) $this->pdo->lastInsertId();
            $this->identity_map->set($session, $sessionId);
            $session->setId($sessionId);
            return $session;
        }
        return false;


    }

    public function update(Session $session): Session|false
    {
        if($this->updateStmt->execute([$session->getHallId(), $session->getMovieId(), $session->getDaysTypeId(),
                                        $session->getPrice(),$session->getStartedAt(),$session->getId(),
        ])){
             $this->identity_map->set($session, $session->getId());
             return $session;
         }
        return false;
    }

    public function delete(Session $session): bool
    {
       $this->identity_map->remove($session, $session->getId());
       return $this->deleteStmt->execute([$session->getId()]);
    }
}