<?php

declare(strict_types=1);

use Nikcrazy37\Hw20\Application\Request\ProcessRequest;
use function DI\get;
use function DI\autowire;
use Dotenv\Dotenv;
use Nikcrazy37\Hw20\Infrastructure\Queue\QueueConnection;
use Nikcrazy37\Hw20\Infrastructure\Queue\Sender;
use Nikcrazy37\Hw20\Infrastructure\Queue\Receiver;
use Nikcrazy37\Hw20\Infrastructure\Queue\Connection;

return array(
    Dotenv::class => Dotenv::createImmutable(ROOT)->load(),
    'Routes' => static fn () => require "routes.php",
    QueueConnection::class => autowire(QueueConnection::class)->constructor(
        DI\env("QUEUE_HOST"),
        DI\env("QUEUE_PORT"),
        DI\env("QUEUE_USER"),
        DI\env("QUEUE_PASSWORD")
    ),
    Connection::class => autowire(Connection::class)->constructor(get(QueueConnection::class))->method("getConnection"),
    Receiver::class => autowire(Receiver::class)->constructor(get(Connection::class))->method("run"),
    Sender::class => autowire(Sender::class)->constructor(get(Connection::class)),
    ProcessRequest::class => autowire(ProcessRequest::class)->constructor(get(\Nikcrazy37\Hw20\Infrastructure\Repository\Redis::class)),
);