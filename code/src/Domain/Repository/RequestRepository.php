<?php
namespace Study\Cinema\Domain\Repository;

use PDO;
use PDOStatement;
use Study\Cinema\Domain\RequestDTO;
use Study\Cinema\Domain\Request;

class RequestRepository
{

    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;

    private UserRepository $userRepository;
    private RequestStatusRepository $requestStatusRepository;
    private RequestTypeRepository $requestTypeRepository;


    public function __construct(PDO $pdo, UserRepository $userRepository, RequestStatusRepository $requestStatusRepository, RequestTypeRepository $requestTypeRepository)
    {
        $this->pdo = $pdo;

        $this->requestStatusRepository = $requestStatusRepository;
        $this->requestTypeRepository = $requestTypeRepository;
        $this->userRepository = $userRepository;


        $this->selectStmt = $pdo->prepare("select * from request where request_id = ?");
        $this->insertStmt = $pdo->prepare("insert into request (user_id, request_type_id, request_status_id, created_at, updated_at) values (?, ?, ?, now(), now())");
        $this->updateStmt = $pdo->prepare("update request set user_id = ?, request_type_id = ?, request_status_id = ? where request_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from request where request_id = ?");
    }

    public function findById($id) : Request
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $user = $this->userRepository->findById($result['user_id']);
        $requestType = $this->requestTypeRepository->findById($result['request_type_id']);
        $requestStatus = $this->requestStatusRepository->findById($result['request_status_id']);

        $request = new Request();
        $request ->setUser($user);
        $request ->setType($requestType);
        $request ->setStatus($requestStatus);

        return  $request;

    }

    public function insertFromDTO(RequestDTO $requestDTO): int
    {
        $this->insertStmt->execute([$requestDTO->getUserId(), $requestDTO->getRequestTypeId(), $requestDTO->getRequestStatusId()]);
        $id = (int) $this->pdo->lastInsertId();
        return (int) $id;
    }


    public function insert(Request $request): int
    {
        $this->insertStmt->execute([$request->getUser()->getId(), $request->getType()->getId(), $request->getStatus()->getId()]);
        $this->id = (int) $this->pdo->lastInsertId();
        return (int) $this->id;
    }

    public function update(RequestReceivedDTO$receivedDTO): bool
    {
        return $this->updateStmt->execute([$receivedDTO->getUserId(), $receivedDTO->getRequestTypeId(), $receivedDTO->getRequestStatusId()]);
    }

    public function updateStatus(int $status_id, int $request_id): bool
    {
        $prepare = $this->pdo->prepare("update request set request_status_id = ? where request_id = ? ");
        return $prepare->execute([$status_id, $request_id]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStmt->execute([$id]);
        $this->id = null;
        return $result;
    }
}



