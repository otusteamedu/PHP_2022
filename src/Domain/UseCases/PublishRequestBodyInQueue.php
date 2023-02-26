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
        $this->queue_publisher->setUpConnection(queue_name: 'bank-statement', routing_key: 'statement.report')
           ->publish(request_body: $request_body)
           ->endPublish();
    }
}
