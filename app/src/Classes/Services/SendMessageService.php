<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Services;

use SGakhramanov\Patterns\Interfaces\Services\SubscriberInterface;

class SendMessageService implements SubscriberInterface
{
    public function update()
    {
        echo "Изменение статуса продукта" . PHP_EOL;
    }
}
