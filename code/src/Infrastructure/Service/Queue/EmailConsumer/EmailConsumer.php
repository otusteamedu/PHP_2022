<?php


namespace Study\Cinema\Infrastructure\Service\Queue\EmailConsumer;

use PhpAmqpLib\Channel\AMQPChannel;
use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Infrastructure\Service\Queue\QueueInterface;


class EmailConsumer implements QueueInterface
{

    private RabbitMQConnector $rabbitMQConnector;
    private AMQPChannel $channel;

    public function __construct(RabbitMQConnector $rabbitMQConnector)
    {
       $this->rabbitMQConnector = $rabbitMQConnector;
    }

    public function get()
    {
        $this->createChanel();
        $callback = function ($msg) {
            echo ' [x] Received email fo send', $msg->body, "\n";
            $data = json_decode($msg->body, true);
            $dto = new EmailReceivedDTO($data);
            $this->sendMail($dto);
        };

        $this->channel->basic_consume(QueueInterface::QUEUE_NAME_EMAIL, '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

    }

    private function createChanel()
    {
       $connection =  $this->rabbitMQConnector->connection();
       $this->channel = $connection->channel();
       $this->channel->queue_declare(QueueInterface::QUEUE_NAME_EMAIL, false, false, false, false);
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
    }

    private function sendMail(EmailReceivedDTO $dto )
    {
        mail($dto->getTo(), $dto->getTitle(), $dto->getTitle());
    }
}