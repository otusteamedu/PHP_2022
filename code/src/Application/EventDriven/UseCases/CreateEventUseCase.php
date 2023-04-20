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
    private ?EventMapper $eventMapper = null;

    public function __construct(PublisherInterface $publisher, AbstractEvent $event)
    {
        $this->publisher = $publisher;
        $this->event = $event;
        $pdo = new PdoGatewayApp();
        if (!is_null($pdo->getClient())) {
            $this->eventMapper = new EventMapper($pdo);
        }
    }

    public function execute(): void
    {
        if (!is_null($this->eventMapper)) {
            $eventModel = new Event(
                mt_rand(1, 100),
                $this->event->getTitle(),
                $this->event->getBody()
            );
            $this->eventMapper->create($eventModel);
        }
        $this->publisher->notify($this->event);
    }
}
