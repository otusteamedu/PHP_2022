<?php

declare(strict_types=1);

use Src\Infrastructure\Routes\Router;
use Src\Infrastructure\Queues\QueuePublisher;
use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;
use Src\Domain\Contracts\Infrastructure\Queues\QueuePublisherGateway;

use function DI\autowire;

return [
    RouterGateway::class => autowire(className: Router::class),
    QueuePublisherGateway::class => autowire(className: QueuePublisher::class),
];
