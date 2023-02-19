<?php
namespace Study\Cinema\Domain\Repository;

use PDO;
use PDOStatement;
use Study\Cinema\Domain\RequestStatus;

class RequestStatusRepository
{

    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("select * from request_status where request_status_id = ?");
        $this->insertStmt = $pdo->prepare("insert into request_status (name) values (?)");
        $this->updateStmt = $pdo->prepare("update request_status set name = ? where request_status_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from request_status where request_status_id = ?");
    }

    public function findById($id) : RequestStatus
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();
        $requestStatus = new RequestStatus();
        $requestStatus->setId($result['request_status_id']);
        $requestStatus->setName($result['name']);

        return $requestStatus;
    }

    public function insert(RequestStatus $requestStatus): int
    {
        $this->insertStmt->execute([$requestStatus->getName()]);
        $requestStatus->setId( (int) $this->pdo->lastInsertId());
        return (int) $requestStatus->getId();
    }

    public function update(RequestStatus $requestStatus): bool
    {
        return $this->updateStmt->execute([ $requestStatus->getName()]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStmt->execute([$id]);
        //$this->id = null;
        return $result;
    }
}



