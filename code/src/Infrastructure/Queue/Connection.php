<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

class Connection
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct(QueueConnection $connectionQueue)
    {
        $this->connection = new AMQPStreamConnection(
            $connectionQueue->getHost(),
            $connectionQueue->getPort(),
            $connectionQueue->getUser(),
            $connectionQueue->getPassword(),
        );

        $this->channel = $this->connection->channel();
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function getChannel(): AMQPChannel|AbstractChannel
    {
        return $this->channel;
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}