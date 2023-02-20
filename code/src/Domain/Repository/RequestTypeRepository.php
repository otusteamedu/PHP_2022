<?php
namespace Study\Cinema\Domain\Repository;

use PDO;
use PDOStatement;
use Study\Cinema\Domain\RequestType;

class RequestTypeRepository
{

    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("select * from request_type where request_type_id = ?");
        $this->insertStmt = $pdo->prepare("insert into request_type (name) values (?)");
        $this->updateStmt = $pdo->prepare("update request_type set name = ? where request_type_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from request_type where request_type_id = ?");
    }

    public function findById($id) : RequestType
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $requestType = new RequestType();
        $requestType->setId($result['request_type_id']);
        $requestType->setName($result['name']);

        return $requestType;
    }

    public function insert(RequestType $requestType): int
    {
        $this->insertStmt->execute([$requestType->getName()]);
        $requestType->setId( (int) $this->pdo->lastInsertId());
        return (int) $requestType->getId();
    }

    public function update(RequestType $requestType): bool
    {
        return $this->updateStmt->execute([ $requestType->getName()]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStmt->execute([$id]);
        //$this->id = null;
        return $result;
    }
}



