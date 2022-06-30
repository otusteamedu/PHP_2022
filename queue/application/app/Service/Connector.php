<?php

namespace App\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connector
{
    public function connect(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            host: $_ENV['RABBIT_MQ_HOST'],
            port: $_ENV['RABBIT_MQ_AMQP_PORT'],
            user: $_ENV['RABBIT_MQ_USER'],
            password: $_ENV['RABBIT_MQ_PASSWORD'],
        );
    }
}
