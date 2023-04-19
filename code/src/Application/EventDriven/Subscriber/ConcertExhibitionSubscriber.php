<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventDriven\Subscriber;

use Svatel\Code\Application\EventsFactory\AbstractEvent;
use Svatel\Code\Application\SendMessage\ConcertExhibitionGenerator;

final class ConcertExhibitionSubscriber implements SubscriberInterface
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function update(AbstractEvent $event, int $userId): void
    {
        $generator = new ConcertExhibitionGenerator($event);
        $message = $generator->createMessage();
        $generator->sendMessage($message, $userId);
    }

    public function getId(): int
    {
        return $this->userId;
    }

    public function getType(): string
    {
        return 'concert_exhibition';
    }
}