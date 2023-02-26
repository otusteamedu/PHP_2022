<?php

declare(strict_types=1);

use Src\Infrastructure\Routes\Router;
use Src\Infrastructure\Queues\{QueueConsumer, QueuePublisher};
use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;
use Src\Domain\Contracts\Infrastructure\Queues\QueuePublisherGateway;
use Src\Application\Contracts\Infrastructure\Queues\QueueConsumerGateway;

use function DI\autowire;

return [
    RouterGateway::class => autowire(className: Router::class),
    QueuePublisherGateway::class => autowire(className: QueuePublisher::class),
    QueueConsumerGateway::class => autowire(className: QueueConsumer::class),
];
