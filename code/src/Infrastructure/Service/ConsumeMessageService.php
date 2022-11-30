<?php

declare(strict_types=1);
declare(ticks = 1);

namespace Nikolai\Php\Infrastructure\Service;

use Nikolai\Php\Infrastructure\MessageHandler\MessageHandlerInterface;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class ConsumeMessageService implements ConsumeMessageInterface
{
    private const CONSUMER_TAG = 'consumerTag';

    private AbstractChannel $channel;

    public function __construct(
        private AMQPStreamConnection $connection,
        private string $queue,
        private string $exchange,
        private MessageHandlerInterface $messageHandler
    )
    {
        if (extension_loaded('pcntl')) {
            define('AMQP_WITHOUT_SIGNALS', false);
            pcntl_signal(SIGQUIT, [$this, 'signalHandler']);
            pcntl_signal(SIGINT, [$this, 'signalHandler']);
        } else {
            echo 'Unable to process signals.' . PHP_EOL;
            exit(1);
        }

        $this->channel = $this->connection->channel();
    }

    public function signalHandler($signalNumber)
    {
        echo PHP_EOL . 'Handling signal: #' . $signalNumber . PHP_EOL;
        if ($signalNumber === SIGQUIT || $signalNumber === SIGINT) {
            $this->channel->basic_cancel(self::CONSUMER_TAG, false, true);
            $this->channel->close();
            $this->connection->close();
        }
    }

    public function consume(): void
    {
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);
        $this->channel->basic_consume(
            $this->queue,
            self::CONSUMER_TAG,
            false,
            false,
            false,
            false,
            [$this->messageHandler, 'handler']);

        echo 'Enter wait.' . PHP_EOL;
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
        echo 'Exit wait.' . PHP_EOL;
    }
}