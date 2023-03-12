<?php

declare(strict_types=1);

namespace App\Infrastructure\Command\Queue;

use App\Infrastructure\Command\CommandInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueueConsumeCommand implements CommandInterface
{
    /**
     * @var mixed|\PhpAmqpLib\Channel\AMQPChannel
     */
    private AMQPChannel $channel;
    private string $queue;

    public function __construct(
        AMQPStreamConnection $connection
    ) {
        $this->queue = 'msgs';
        $exchange = 'router';

        $this->channel = $connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false,false);
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $exchange);
    }

    public static function getDescription(): string
    {
        return 'Обработка сообщений из очереди RabbitMQ';
    }

    public function execute(array $arguments): void
    {
        print_r('Настройка обработчика ...' . PHP_EOL);
        $consumerTag = 'consumer';

        $this->channel->basic_consume(
            $this->queue,
            $consumerTag,
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        print_r('Запускаем обработку сообщений' . PHP_EOL);
        $this->channel->consume();
    }

    public function processMessage(AMQPMessage $message) {
        print_r('Получено новое сообщение' . PHP_EOL);

        print_r(PHP_EOL . '--------' . PHP_EOL);
        echo $message->body;
        print_r(PHP_EOL . '--------' . PHP_EOL);

        $message->ack();

        // Send a message with the string "quit" to cancel the consumer.
        if ($message->body === 'quit') {
            $message->getChannel()->basic_cancel($message->getConsumerTag());
        }
    }
}