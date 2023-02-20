<?php


namespace Study\Cinema\Infrastructure\Service\Queue\RequestConsumer;

use PhpAmqpLib\Channel\AMQPChannel;
use Study\Cinema\Domain\Request;
use Study\Cinema\Domain\RequestStatus;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Infrastructure\Service\Queue\QueueInterface;
use Study\Cinema\Infrastructure\Service\Request\RequestService;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;
use Study\Cinema\Domain\Repository\RequestRepository;

class RequestConsumer implements QueueInterface
{

    private RabbitMQConnector $rabbitMQConnector;
    private RequestService $requestService;
    private EmailPublisher $emailPublisher;

    private RequestRepository $requestRepository;

    private AMQPChannel $channel;

    public function __construct(RabbitMQConnector $rabbitMQConnector, RequestService $requestService, EmailPublisher $emailPublisher, RequestRepository $requestRepository )
    {
       $this->rabbitMQConnector = $rabbitMQConnector;
       $this->requestService = $requestService;
       $this->emailPublisher = $emailPublisher;
       $this->requestRepository = $requestRepository;
    }

    public function get()
    {
        $this->createChanel();

        $callback = function ($msg) {

            echo ' [x] Received request with data', $msg->body, "\n";

            $data = json_decode($msg->body, true);
            $dto = new RequestReceivedDTO($data);

            $requestNumber =  $this->requestRepository->updateStatus(RequestStatus::REQUEST_STATUS_IN_PROCESS , $data['request_id']);

            //обработка и получение результата
            if($this->makeRequest($dto)){
                echo " Выписка сформирована. Данные отправлены.";
                $requestNumber =  $this->requestRepository->updateStatus(RequestStatus::REQUEST_STATUS_COMPLETED , $data['request_id']);
            }


        };
        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_REQUEST, '', false, true, false, false, $callback);
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

    }

    private function createChanel()
    {
       $connection =  $this->rabbitMQConnector->connection();
       $this->channel = $connection->channel();

        $this->channel->queue_declare(QueueInterface::QUEUE_NAME_REQUEST, false, false, false, false);
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

    }
    /**
     * Метод формирует данные выписки и отпавляет готовую выписку
    **/
    private function makeRequest(RequestReceivedDTO $dto)
    {
        return $this->requestService->createRequest($dto, $this->emailPublisher);
    }


}