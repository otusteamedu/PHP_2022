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

    public function __construct(
        AMQPStreamConnection $connection,
        private readonly string $exchange,
        private readonly string $queue
    ) {
        $this->channel = $connection->channel();
        $this->channel->queue_declare($queue, false, true, false,false);
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($queue, $exchange);
    }

    public function dispatch(MessageInterface $message): void
    {
        $AMQPMessage = new AMQPMessage(
            $message->getBody(),
            [
                'content_type' => 'text/plain',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($AMQPMessage, $this->exchange);
    }
}