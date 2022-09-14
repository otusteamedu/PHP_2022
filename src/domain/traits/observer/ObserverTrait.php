<?php

namespace Mselyatin\Patterns\domain\traits\observer;

use Mselyatin\Patterns\domain\interfaces\observer\PublisherInterface;
use Mselyatin\Patterns\domain\interfaces\observer\SubscriberInterface;

/**
 * Трейт наблюдателя
 */
trait ObserverTrait
{
    /**
     * @var SubscriberInterface[]
     */
    protected array $subscribers = [];

    /**
     * @param SubscriberInterface $subscriber
     * @return void
     */
    public function subscribe(SubscriberInterface $subscriber): void
    {
        if (!in_array($subscriber, $this->subscribers)) {
            $this->subscribers[] = $subscriber;
        }
    }

    /**
     * @param SubscriberInterface $subscriber
     * @return void
     */
    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        if ($key = array_search($subscriber, $this->subscribers)) {
            unset($this->subscribers[$key]);
            $this->subscribers = array_values($this->subscribers);
        }
    }

    /**
     * @param PublisherInterface $publisher
     * @return void
     */
    protected function notifySubscribers(PublisherInterface $publisher): void
    {
        array_walk($this->subscribers, function (SubscriberInterface $subscriber) use ($publisher) {
            $subscriber->notify($publisher);
        });
    }
}