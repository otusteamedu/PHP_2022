<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventDriven\UseCases;

use Svatel\Code\Application\EventDriven\Publisher\PublisherInterface;
use Svatel\Code\Application\EventsFactory\AbstractEvent;
use Svatel\Code\Application\Pdo\PdoGatewayApp;
use Svatel\Code\Domain\Event;
use Svatel\Code\Domain\EventMapper;

final class CreateEventUseCase
{
    private PublisherInterface $publisher;
    private AbstractEvent $event;

    public function __construct(PublisherInterface $publisher, AbstractEvent $event)
    {
        $this->publisher = $publisher;
        $this->event = $event;
    }

    public function execute(): void
    {
        $pdo = new PdoGatewayApp();
        $mapper = new EventMapper($pdo);
        $eventModel = new Event(
            mt_rand(1, 100),
            $this->event->getTitle(),
            $this->event->getBody()
        );
        $mapper->create($eventModel);
        $this->publisher->notify($this->event);
    }
}
