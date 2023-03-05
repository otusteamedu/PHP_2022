<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue;

use DKozlov\Otus\Application;
use DKozlov\Otus\Domain\Queue\MessageInterface;
use DKozlov\Otus\Domain\Queue\QueueInterface;
use Exception;
use JsonException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractQueue implements QueueInterface
{
    protected string $queue = '';

    protected string $callbackQueue = '';

    protected ?string $response = null;

    protected ?string $correlationId = null;

    public function publish(MessageInterface $message): void
    {
        $connection = $this->getConnection();
        $channel = $connection->channel();

        $sendMessage = new AMQPMessage($message->serialize());
        $channel->basic_publish($sendMessage, '', $this->queue);

        $channel->close();
        $connection->close();
    }

    public function publishWithResponse(MessageInterface $message): string
    {
        $connection = $this->getConnection();
        $channel = $connection->channel();

        $this->response = null;
        $this->correlationId = uniqid('', true);

        [$this->callbackQueue, ,] = $channel->queue_declare(
            "",
            false,
            false,
            true,
            false
        );

        $channel->basic_consume(
            $this->callbackQueue,
            '',
            false,
            false,
            false,
            false,
            fn (AMQPMessage $message) => $this->onResponse($message)
        );

        $this->sendMessage($channel, $message->serialize(), $this->queue, [
            'correlation_id' => $this->correlationId,
            'reply_to' => $this->callbackQueue
        ]);

        while (!$this->response) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();

        return $this->response;
    }

    public function receive(): void
    {
        $connection = $this->getConnection();
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, false, false, false);

        $channel->basic_consume(
            $this->queue,
            '',
            false,
            false,
            false,
            false,
            fn (AMQPMessage $message) => $this->callback($message)
        );

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    protected function onResponse(AMQPMessage $message): void
    {
        if ($message->get('correlation_id') === $this->correlationId) {
            $this->response = $message->getBody();
        }
    }

    /**
     * @throws JsonException
     */
    abstract protected function callback(AMQPMessage $message): void;

    protected function sendMessage(AMQPChannel $channel, string $body, string $routingKey = '', array $options = []): void
    {
        $sendMessage = new AMQPMessage($body, $options);

        $channel->basic_publish($sendMessage, '', $routingKey);
    }

    /**
     * @throws Exception
     */
    protected function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            Application::config('RABBITMQ_HOST'),
            Application::config('AMQP_PORT'),
            Application::config('RABBITMQ_USER'),
            Application::config('RABBITMQ_PASSWORD')
        );
    }
}