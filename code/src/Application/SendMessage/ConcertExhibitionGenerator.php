<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

final class ConcertExhibitionGenerator extends SendMessageGenerator
{
    public function createMessage(): Message
    {
        $body = 'Название концерта: ' . $this->event->getBody()['concert_title'];
        return new Message('Добавлен новый концерт, где будет проводится выставка', $body);
    }
}