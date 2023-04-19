<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

use Svatel\Code\Application\EventsFactory\AbstractEvent;

abstract class SendMessageGenerator
{
    protected AbstractEvent $event;

    public function __construct(AbstractEvent $event)
    {
        $this->event = $event;
    }

    public function sendMessage(Message $message, int $userId): void
    {
        // отправка уведомления
    }

    abstract public function createMessage(): Message;
}
