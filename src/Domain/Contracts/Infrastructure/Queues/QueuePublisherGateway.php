<?php

declare(strict_types=1);

namespace Src\Domain\Contracts\Infrastructure\Queues;

interface QueuePublisherGateway
{
    /**
     * @return $this
     */
    public function setUpConnection(string $queue_name, string $routing_key): self;

    /**
     * @param string $request_body
     * @return $this
     */
    public function publish(string $request_body): self;

    /**
     * @return void
     */
    public function endPublish(): void;
}
