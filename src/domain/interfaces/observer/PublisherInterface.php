<?php

namespace Mselyatin\Patterns\domain\interfaces\observer;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber);
    public function unsubscribe(SubscriberInterface $subscriber);
}