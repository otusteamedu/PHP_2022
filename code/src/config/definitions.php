<?php

declare(strict_types=1);

use function DI\get;
use function DI\autowire;
use Dotenv\Dotenv;
use Nikcrazy37\Hw16\Router;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\QueueConnection;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\Sender;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\Receiver;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\Connection;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Telegram\ApiBot;

return array(
    Dotenv::class => Dotenv::createImmutable(ROOT)->load(),
    Router::class => autowire(Router::class),
    QueueConnection::class => autowire(QueueConnection::class)->constructor(
        DI\env("QUEUE_HOST"),
        DI\env("QUEUE_PORT"),
        DI\env("QUEUE_USER"),
        DI\env("QUEUE_PASSWORD")
    ),
    Connection::class => autowire(Connection::class)->constructor(get(QueueConnection::class))->method("getConnection"),
    Receiver::class => autowire(Receiver::class)->constructor(get(Connection::class))->method("run"),
    Sender::class => autowire(Sender::class)->constructor(get(Connection::class)),
    ApiBot::class => autowire(ApiBot::class)->constructor(
        DI\env("TELEGRAM_API_ID"),
        DI\env("TELEGRAM_API_HASH"),
        DI\env("TELEGRAM_CHAT_ID"),
    ),
);