<?php

namespace Study\Cinema\Infrastructure\Controller\Api\v1;

use Study\Cinema\Domain\RequestStatus;
use Study\Cinema\Infrastructure\Response\Response;
use Study\Cinema\Infrastructure\Service\Queue\RequestConsumer\RequestReceivedDTO;
use Study\Cinema\Infrastructure\Service\Queue\RequestPublisher\RequestPublisher;
use Study\Cinema\Infrastructure\Service\Request\RequestService;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;


use Study\Cinema\Infrastructure\DB\DBConnection;
use Study\Cinema\Domain\Repository\RequestRepository;
use Study\Cinema\Domain\Repository\RequestStatusRepository;
use Study\Cinema\Domain\Repository\RequestTypeRepository;
use Study\Cinema\Domain\Repository\UserRepository;


class RequestController
{
    private RequestService $requestService;

    public  function index()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $this->post();
        }
        else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->get();
        }
    }
    private function post()
    {

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать заявку" );
        }

        $cn = new RabbitMQConnector();

        $pdo = (new DBConnection())->getConnection();
        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $data = $_REQUEST;
        $data['request_status_id'] = RequestStatus::REQUEST_STATUS_INIT;
        $dto = new RequestReceivedDTO($data);


        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository );
        $requestNumber = $requestRepository->insertFromDTO($dto);

        $data['request_id'] = $requestNumber;
        $publisher = new  RequestPublisher($cn);
        $publisher->send($data);

        if($requestNumber)
        {
            Response::send(Response::HTTP_CODE_OK, "Ваш запрос принят в работу. Номер отслеживания ".$requestNumber );

        }
        else {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать заявку" );
        }

    }

    private function get()
    {

        $pdo = (new DBConnection())->getConnection();
        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $request_id = $_GET['request_id'];

        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository );
        $request = $requestRepository->findById($request_id);

        if($request) {
            Response::send(Response::HTTP_CODE_OK, "Ваш запрос $request_id имеет статус ".$request->getStatus()->getName());
        }
        else {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось получить статус" );
        }

    }

}