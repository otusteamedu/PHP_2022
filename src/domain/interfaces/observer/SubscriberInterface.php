<?php

namespace Mselyatin\Patterns\domain\interfaces\observer;

interface SubscriberInterface
{
    public function notify(PublisherInterface $publisher);
}