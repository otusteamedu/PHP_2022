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

    private const DEFAULT_QUEUE = 'default';
    private const DEFAULT_EXCHANGE = 'default';

    private const ALLOWED_OPTIONS = [
        'queue',
        'exchange'
    ];

    public function __construct(
        AMQPStreamConnection $connection
    ) {
        $this->channel = $connection->channel();
    }

    public static function getDescription(): string
    {
        return 'Обработка сообщений из очереди RabbitMQ';
    }

    // Пример вызова:
    // bin/console queue:consume --queue=msgs --exchange=router
    public function execute(array $arguments): void
    {
        $options = $this->getOptions($arguments);

        $queue = $options['queue'] ?? self::DEFAULT_QUEUE;
        $exchange = $options['exchange'] ?? self::DEFAULT_EXCHANGE;

        print_r('Настройка обработчика ...' . PHP_EOL);
        $this->configureChannel($queue, $exchange);

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

    private function getOptions(array $arguments): array
    {
        $options = [];

        foreach ($arguments as $argument) {
            [$optionName, $optionValue] = \explode('=', \strtr($argument, ['--' => '']));
            if (!\in_array($optionName, self::ALLOWED_OPTIONS)) {
                throw new \RuntimeException(\sprintf(
                    'Опция %s не поддерживается. Список поддерживаемых опций: %s',
                    $optionName,
                    \implode(',', self::ALLOWED_OPTIONS)
                ));
            }
            $options[$optionName] = $optionValue;
        }

        return $options;
    }

    private function configureChannel(string $queue, string $exchange): void
    {
        $this->channel->queue_declare($queue, false, true, false,false);
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($queue, $exchange);

        $consumerTag = 'consumer';

        $this->channel->basic_consume(
            $queue,
            $consumerTag,
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );
    }
}