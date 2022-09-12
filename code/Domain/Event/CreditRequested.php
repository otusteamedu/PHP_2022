<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Application\Component\DataMapper\IdentityMap;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CreditRequested extends Event
{
    public function __construct(
        private readonly array $eventData,
        private readonly IdentityMap $identityMap,
        private readonly AMQPStreamConnection $amqpConnection
    ) {
    }

    public function getEventData(): array
    {
        return $this->eventData;
    }

    public function getIdentityMap(): IdentityMap
    {
        return $this->identityMap;
    }

    public function getAmqpConnection(): AMQPStreamConnection
    {
        return $this->amqpConnection;
    }
}