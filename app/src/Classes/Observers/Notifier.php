<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Observers;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Services\SubscriberInterface;

class Notifier implements NotifierInterface
{
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        if (!in_array($subscriber, $this->subscribers)) {
            $this->subscribers[] = $subscriber;
        }
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        if (in_array($subscriber, $this->subscribers)) {
            unset($this->subscribers[array_search($subscriber, $this->subscribers[])]);
        }
    }

    public function notify(): void
    {
        array_walk($this->subscribers, fn($subscriber) => $subscriber->update());
    }
}
