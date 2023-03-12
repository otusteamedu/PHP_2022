<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Rabbit;

use App\Application\Queue\BusInterface;
use App\Application\Queue\MessageInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitBus implements BusInterface
{
    private AMQPChannel $channel;
    private string $exchange;

    public function __construct(AMQPStreamConnection $connection) {
        $queue = 'msgs';
        $this->exchange = 'router';

        $this->channel = $connection->channel();
        $this->channel->queue_declare($queue, false, true, false,false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($queue, $this->exchange);
    }

    public function dispatch(MessageInterface $message): void
    {
        $body = serialize(['message' => $message]);
        $AMQPMessage = new AMQPMessage(
            $body,
            [
                'content_type' => 'text/plain',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($AMQPMessage, $this->exchange);
    }
}