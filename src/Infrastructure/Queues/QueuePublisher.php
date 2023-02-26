<?php

declare(strict_types=1);

namespace Src\Infrastructure\Queues;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Src\Domain\Contracts\Infrastructure\Queues\QueuePublisherGateway;

final class QueuePublisher implements QueuePublisherGateway
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var string
     */
    private string $queue_name;

    /**
     * @var string
     */
    private string $routing_key;

    /**
     * @var AbstractChannel
     */
    private AbstractChannel $channel;

    /**
     * @return $this
     * @throws \Exception
     */
    public function setUpConnection(string $queue_name, string $routing_key): self
    {
        $this->queue_name = $queue_name;
        $this->routing_key = $routing_key;

        $this->connection = new AMQPStreamConnection(
            host: $_ENV['RABBITMQ_HOST'],
            port: $_ENV['RABBITMQ_PORT'],
            user: $_ENV['RABBITMQ_USERNAME'],
            password: $_ENV['RABBITMQ_PASSWORD']
        );

        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare(
            exchange: $_ENV['RABBITMQ_EXCHANGE'],
            type: $_ENV['RABBITMQ_EXCHANGE_TYPE'],
            passive: false,
            durable: false,
            auto_delete: false
        );

        $this->channel->queue_declare(
            queue: $this->queue_name,
            passive: false,
            durable: false,
            exclusive: false,
            auto_delete: false
        );

        $this->channel->queue_bind(
            queue: $this->queue_name,
            exchange: $_ENV['RABBITMQ_EXCHANGE'],
            routing_key: $this->routing_key
        );

        return $this;
    }

    /**
     * @param string $request_body
     * @return $this
     */
    public function publish(string $request_body): self
    {
        $message = new AMQPMessage(body: $request_body);
        $this->channel->basic_publish(
            msg: $message,
            exchange: $_ENV['RABBITMQ_EXCHANGE'],
            routing_key: $this->routing_key
        );

        return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function endPublish(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
