<?php

namespace App\Services\QueueServices;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class AbstractRabbitService
{
    protected const QUEUE = 'report';
    protected const EXCHANGE = 'router';
    protected const EXCHANGE_TYPE = 'direct';

    protected AMQPChannel $channel;

    protected AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('AMQP_HOSt'),
            env('AMQP_PORT'),
            env('AMQP_USER'),
            env('AMQP_PASSWORD'),
            env('AMQP_VHOST')
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(self::QUEUE, false, true, false, false);
        $this->channel->exchange_declare(self::EXCHANGE, self::EXCHANGE_TYPE, false, true, false);

        register_shutdown_function([$this, 'shutdown'], $this->channel, $this->connection);
    }

    /**
     * @throws Exception
     */
    public function shutdown(AMQPChannel $channel, AMQPStreamConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }
}
