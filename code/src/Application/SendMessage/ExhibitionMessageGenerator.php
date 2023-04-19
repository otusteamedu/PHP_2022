<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

final class ExhibitionMessageGenerator extends SendMessageGenerator
{
    public function createMessage(): Message
    {
        return new Message('Добавлен новая выставка', 'Название: ' . $this->event->getBody()['name']);
    }
}
