<?php

declare(strict_types=1);

namespace App\Infrastructure\Command\Queue;

use App\Application\Queue\HandlerInterface;
use App\Application\Queue\MessageInterface;
use App\Infrastructure\Command\AbstractCommand;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueueConsumeCommand extends AbstractCommand
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

    public function processMessage(AMQPMessage $AMQPMessage) {
        print_r('Получено новое сообщение' . PHP_EOL);

        /** @var array{message: MessageInterface} $body */
        $body = unserialize($AMQPMessage->getBody());
        $message = $body['message'];

        /** @var HandlerInterface $handler */
        $handler = $this->container->get($message->getHandlerClass());

        print_r('Начало обработки сообщения ' . $message::class . PHP_EOL);
        $handler->handle($message);
        print_r('Сообщение обработано' . PHP_EOL . PHP_EOL);

        $AMQPMessage->ack();

        // Send a message with the string "quit" to cancel the consumer.
        if ($AMQPMessage->body === 'quit') {
            $AMQPMessage->getChannel()->basic_cancel($AMQPMessage->getConsumerTag());
        }
    }
}