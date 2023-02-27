<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Domain;

use Eliasj\Hw16\App\Kernel\Configs\RabbitConfig;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queue
{
    private string $user;
    private string $password;

    private AMQPStreamConnection $connection;

    private AMQPChannel $channel;
    public function __construct()
    {
        $config = RabbitConfig::getInstance();
        $this->user = $config->user;
        $this->password = $config->pass;
    }

    public function sendMessage(array $data): void
    {
        $this->setConnection();
        $this->setChannel();


        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', 'default');

        $this->channel->close();
        $this->connection->close();
    }

    public function listenChannel(): void
    {
        $this->setConnection();
        $this->setChannel();

        $callback = function ($msg) {
            $data = json_decode($msg->body);
            SendEmail::run($data->email, $data->message);
            echo " [x] Received ", $data->message, "\n";
        };

        $this->channel->basic_consume('default', '', false, true, false, false, $callback);
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }

    private function setConnection(): void
    {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, $this->user, $this->password);
    }
    private function setChannel(): void
    {
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('default', false, false, false, false);
    }
}
