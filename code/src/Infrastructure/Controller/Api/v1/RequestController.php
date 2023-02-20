<?php

namespace Study\Cinema\Infrastructure\Controller\Api\v1;

use Study\Cinema\Domain\RequestDTO;
use Study\Cinema\Domain\RequestStatus;
use Study\Cinema\Infrastructure\Response\Response;
use Study\Cinema\Infrastructure\Service\Queue\RequestPublisher\RequestPublisher;
use Study\Cinema\Infrastructure\Service\Request\RequestService;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;


use Study\Cinema\Infrastructure\DB\DBConnection;
use OpenApi\Annotations as OA;



/**
 * @OA\Info(title=" API для выполнение запросов пользователя ", version="0.1")
 */
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

    /**
     * @OA\Post(
     *     path="/api/v1/request/post",
     *     summary="Отправить запрос на получение данных опредленного типа",
     *     @OA\Parameter (in = "query",  name = "user_id", required = true, description = "Пользовататель", example = "22", @OA\Schema(type = "integer")),
     *     @OA\Parameter (in = "query",  name = "request_type_id", required = true, description = "Тип запроса",  example = "22", @OA\Schema(type = "integer")),
     *     @OA\Parameter (in = "query",  name = "email", required = true, description = "Куда отправить результат",  example = "test@example.com", @OA\Schema(type = "string")),
     *     @OA\Parameter (in = "query",  name = "dateFrom", required = true, description = "Дата начала периода",  example = "27.11.2012", @OA\Schema(type = "string")),
     *     @OA\Parameter (in = "query",  name = "dateTill", required = true, description = "Дата окончания периода",  example = "27.11.2022", @OA\Schema(type = "string")),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="BAD REQUEST"),

     * )
     */
    public function post()
    {

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать заявку" );
        }

        $cn = new RabbitMQConnector();
        $pdo = (new DBConnection())->getConnection();

        $data = $_REQUEST;
        $data['request_status_id'] = RequestStatus::REQUEST_STATUS_INIT;

        $dto = new RequestDTO($data);
        $requestService = new RequestService();
        $requestNumber = $requestService->saveRequest($pdo, $dto);


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

    /**
     * @OA\Get(
     *     path="/api/v1/request/get{request_id}",
     *     summary="Получение статуса запроса",
     *     @OA\Parameter (in = "query",  name = "request_id", required = true, description = "Номер запроса", example = "22" ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="BAD REQUEST"),

     * )
     */
    public function get()
    {

        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось получить статус" );
        }

        $request_id = $_GET['request_id'];
        $pdo = (new DBConnection())->getConnection();

        $requestService = new RequestService();
        $request = $requestService->getRequest($pdo, $request_id);

        if($request) {
            Response::send(Response::HTTP_CODE_OK, "Ваш запрос $request_id имеет статус ".$request->getStatus()->getName());
        }
        else {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось получить статус" );
        }

    }

}