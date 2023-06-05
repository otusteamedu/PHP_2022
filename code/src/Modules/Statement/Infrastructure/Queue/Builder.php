<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue;

use Nikcrazy37\Hw16\Libs\Core\DI\DIContainer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;
use DI\Container;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Telegram\ApiBot;

class Builder
{
    protected Connection $connection;
    protected AMQPChannel|AbstractChannel $channel;
    protected Container $container;
    protected ApiBot $telegramBot;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->getChannel();
        $this->channel->queue_declare('task_queue', false, true, false, false);

        $this->container = DIContainer::build();
        $this->telegramBot = $this->container->get(ApiBot::class);
    }
}