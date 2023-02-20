<?php

namespace Study\Cinema\Infrastructure\Service\Request;

use Study\Cinema\Domain\Repository\RequestRepository;
use Study\Cinema\Domain\Repository\RequestStatusRepository;
use Study\Cinema\Domain\Repository\RequestTypeRepository;
use Study\Cinema\Domain\Repository\UserRepository;
use Study\Cinema\Domain\Request;
use Study\Cinema\Domain\RequestDTO;
use Study\Cinema\Infrastructure\Service\Queue\RequestConsumer\RequestReceivedDTO;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;
use PDO;


class RequestService
{
    public function createRequest(RequestReceivedDTO $dto, EmailPublisher $emailPublisher): bool
    {
        //сходить в базу собрать данные
         sleep(5);

        //отправить письмо с итогом
        $emailPublisher->send(['from' => 'config.email', 'title'=> 'letter_title', 'to' => $dto->getEmail(), 'body' => [1, 2, 3, 4] ]);
        return true;
    }
    public function saveRequest(PDO $pdo, RequestDTO $requestDTO)
    {

        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository);

        return $requestRepository->insertFromDTO($requestDTO);

    }

    public function getRequest(PDO $pdo, int $request_id): Request
    {
        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);

        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository );
        return $requestRepository->findById($request_id);


    }

}