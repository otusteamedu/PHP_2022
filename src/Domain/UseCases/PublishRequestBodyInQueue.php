<?php

declare(strict_types=1);

namespace Src\Domain\UseCases;

use Src\Domain\Contracts\Infrastructure\Queues\QueuePublisherGateway;

final class PublishRequestBodyInQueue
{
    /**
     * @param QueuePublisherGateway $queue_publisher
     */
    public function __construct(private readonly QueuePublisherGateway $queue_publisher)
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function publish(string $request_body): void
    {
        $this->queue_publisher->setUpConnection(
            queue_name: $_ENV['QUEUE_NAME'],
            routing_key: $_ENV['QUEUE_ROUTING_KEY']
        )
           ->publish(request_body: $request_body)
           ->endPublish();
    }
}
