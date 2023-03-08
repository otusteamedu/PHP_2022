<?php

declare(strict_types=1);

namespace ApplicationContracts\Queue;

interface QueuePublisherGateway
{
    /**
     * @param string $queue_name
     * @param string $routing_key
     * @param string $request_body
     * @return void
     */
    public function publish(string $queue_name, string $routing_key, string $request_body): void;
}
