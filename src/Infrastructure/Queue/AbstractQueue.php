<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue;

use DKozlov\Otus\Application;
use DKozlov\Otus\Domain\Queue\QueueInterface;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class AbstractQueue implements QueueInterface
{
    protected AMQPStreamConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            Application::config('RABBITMQ_HOST'),
            Application::config('AMQP_PORT'),
            Application::config('RABBITMQ_USER'),
            Application::config('RABBITMQ_PASSWORD')
        );
    }
}