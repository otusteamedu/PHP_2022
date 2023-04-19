<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventDriven\Subscriber;

use Svatel\Code\Application\EventsFactory\AbstractEvent;

interface SubscriberInterface
{
    public function update(AbstractEvent $event, int $userId): void;
    public function getId(): int;
    public function getType(): string;
}
