<?php

namespace App\Service;

use Closure;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Channel
{
    private Connector $connector;
    private AMQPStreamConnection $AMQPStreamConnection;
    private AMQPChannel $AMQPChannel;
    private TelegramSender $telegramSender;

    public function __construct(Connector $connector, TelegramSender $telegramSender)
    {
       $this->connector = $connector;
       $this->telegramSender = $telegramSender;
    }

    public function connect(): Channel
    {
        $this->AMQPStreamConnection = $this->connector->connect();
        $this->AMQPChannel = $this->AMQPStreamConnection->channel();

        return $this;
    }

    public function open(string $queue): Channel
    {
        $this->AMQPChannel->queue_declare(
            queue: $queue,
            passive: false,
            durable: false,
            exclusive:  false,
            auto_delete: false
        );

        return $this;
    }

    public function publish(AMQPMessage $message, string $queue): Channel
    {
        $this->AMQPChannel->basic_publish($message, '', $queue);

        return $this;
    }

    public function consume(string $queue): Channel
    {
        $this->AMQPChannel->basic_consume(
            queue: $queue,
            consumer_tag: '',
            no_local: false,
            no_ack: true,
            exclusive: false,
            nowait: false,
            callback: $this->getCallback()
        );

        return $this;
    }

    public function read(): void
    {
        while ($this->AMQPChannel->is_open()) {
            $this->AMQPChannel->wait();
        }
    }

    /**
     * @throws Exception
     */
    public function close(): void
    {
        $this->AMQPChannel->close();
        $this->AMQPStreamConnection->close();
    }

    private function getCallback(): Closure
    {
        return function (AMQPMessage $msg) {
            $this->telegramSender->send($msg->body);
            echo "$msg->body\n";
        };
    }
}
