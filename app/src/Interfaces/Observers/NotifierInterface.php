<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Interfaces\Observers;

use SGakhramanov\Patterns\Interfaces\Services\SubscriberInterface;

interface NotifierInterface
{
    public function subscribe(SubscriberInterface $subscriber);

    public function unsubscribe(SubscriberInterface $subscriber);

    public function notify();
}
