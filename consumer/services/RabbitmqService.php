<?php

namespace app\services;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqService
{
    private AMQPStreamConnection $connection;

    public function __construct() {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_USERNAME'],
            $_ENV['RABBITMQ_PASSWORD']
        );
    }

    public function getConnection(): AMQPStreamConnection {
        return $this->connection;
    }
}
