<?php


namespace Study\Cinema\Infrastructure\Service\Queue\StatementConsumer;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Infrastructure\Service\Queue\QueueInterface;
use Study\Cinema\Infrastructure\Service\Queue;
use Study\Cinema\Infrastructure\Service\Statement\StatementService;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;

class StatementConsumer implements QueueInterface
{

    private RabbitMQConnector $rabbitMQConnector;
    private StatementService $statementService;
    private EmailPublisher $emailPublisher;


    private AMQPChannel $channel;

    public function __construct(RabbitMQConnector $rabbitMQConnector, StatementService $statementService, EmailPublisher $emailPublisher )
    {
       $this->rabbitMQConnector = $rabbitMQConnector;
       $this->statementService = $statementService;
       $this->emailPublisher = $emailPublisher;
    }

    public function get()
    {
        $this->createChanel();


        $callback = function ($msg) {
          //  echo ' [x] Received ', $msg->body, "\n";
            //$data  = explode(",", $msg->body);
            $data = json_decode($msg->body, true);
            $dto = new StatementReceivedDTO($data);
            echo ' [x] Received ', $msg->body, "\n";

            //обработка и получение результата
           echo  $this->getStatement($dto);
        };

        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_STATEMENT, '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

       
    }

    private function createChanel()
    {
       $connection =  $this->rabbitMQConnector->connection();
       $this->channel = $connection->channel();

        $this->channel->queue_declare(QueueInterface::QUEUE_NAME_STATEMENT, false, false, false, false);
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

    }

    private function getStatement(StatementReceivedDTO $dto )
    {
        return $this->statementService->createStatement($dto, $this->emailPublisher);
    }


}