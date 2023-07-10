<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Queue;

use Nikcrazy37\Hw20\Libs\Core\DI\DIContainer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;
use DI\Container;

class Builder
{
    protected Connection $connection;
    protected AMQPChannel|AbstractChannel $channel;
    protected Container $container;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->getChannel();
        $this->channel->queue_declare('task_queue', false, true, false, false);

        $this->container = DIContainer::build();
    }
}