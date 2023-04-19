<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

final class ConcertMessageGenerator extends SendMessageGenerator
{
    public function createMessage(): Message
    {
        return new Message('Добавлен новый концерт', 'Название: ' . $this->event->getBody()['name']);
    }
}
