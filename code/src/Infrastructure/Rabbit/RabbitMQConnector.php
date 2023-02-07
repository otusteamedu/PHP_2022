<?php

namespace Study\Cinema\Infrastructure\Rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnector
{
    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = $this->create();
    }
    public function connection() : AMQPStreamConnection
    {
        return $this->connection;
    }

    public function channel(?int $channel_id = null): AMQPChannel
    {
        return $this->connection->channel($channel_id);
    }

    private function create() : AMQPStreamConnection
    {

        return new AMQPStreamConnection(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_DEFAULT_USER'),
            getenv('RABBITMQ_DEFAULT_PASS'),

        );

    }

}