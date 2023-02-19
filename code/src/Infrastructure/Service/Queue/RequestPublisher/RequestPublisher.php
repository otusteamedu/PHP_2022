<?php

namespace Study\Cinema\Infrastructure\Service\Queue\RequestPublisher;

use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use Study\Cinema\Infrastructure\Service\Queue\QueueInterface;

class RequestPublisher implements QueueInterface
{

    private RabbitMQConnector $rabbitMQConnector;
    private AMQPChannel $channel;

    public function __construct(RabbitMQConnector $rabbitMQConnector)
    {
        $this->rabbitMQConnector = $rabbitMQConnector;
    }

    public function send(array $data)
    {
        $this->createChanel();
        $message = $this->createMessage($data);

        $this->channel->basic_publish($message, '', self::QUEUE_NAME_REQUEST);
        $this->channel->close();

    }

    private function createChanel()
    {
        $connection =  $this->rabbitMQConnector->connection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME_REQUEST, false, false, false, false);

    }

    private function createMessage(array $data): AMQPMessage
    {
        $dto  = new RequestSendDTO($data);
        return new AMQPMessage($dto->toAMQPMessage());
    }
}