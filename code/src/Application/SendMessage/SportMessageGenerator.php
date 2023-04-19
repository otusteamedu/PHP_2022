<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

final class SportMessageGenerator extends SendMessageGenerator
{
    public function createMessage(): Message
    {
        return new Message('Добавлено новое спортивное мероприятие', 'Название: ' . $this->event->getBody()['name']);
    }
}
