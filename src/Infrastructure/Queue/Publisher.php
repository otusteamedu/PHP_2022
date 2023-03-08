<?php

declare(strict_types=1);

namespace Infrastructure\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use ApplicationContracts\Queue\QueuePublisherGateway;

final class Publisher implements QueuePublisherGateway
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var AbstractChannel
     */
    private AbstractChannel $channel;

    /**
     * @param string $queue_name
     * @param string $routing_key
     * @param string $request_body
     * @return void
     * @throws \Exception
     */
    public function publish(string $queue_name, string $routing_key, string $request_body): void
    {
        $this->setUpConnection(queue_name: $queue_name, routing_key: $routing_key);

        $message = new AMQPMessage(body: $request_body);
        $this->channel->basic_publish(
            msg: $message,
            exchange: $_ENV['RABBITMQ_EXCHANGE'],
            routing_key: $routing_key
        );

        $this->endPublish();
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param string $queue_name
     * @param string $routing_key
     * @return void
     * @throws \Exception
     */
    private function setUpConnection(string $queue_name, string $routing_key): void
    {
        $queue_name1 = $queue_name;

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
            queue: $queue_name1,
            passive: false,
            durable: false,
            exclusive: false,
            auto_delete: false
        );

        $this->channel->queue_bind(
            queue: $queue_name1,
            exchange: $_ENV['RABBITMQ_EXCHANGE'],
            routing_key: $routing_key
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function endPublish(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
