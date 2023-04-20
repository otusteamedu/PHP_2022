<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventDriven\Publisher;

use Svatel\Code\Application\EventDriven\Subscriber\SubscriberInterface;
use Svatel\Code\Application\EventsFactory\AbstractEvent;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;
    public function notify(AbstractEvent $event): void;
}
