<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventDriven\Publisher;

use Svatel\Code\Application\EventDriven\Subscriber\ConcertExhibitionSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\ConcertSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\ExhibitionSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\SportSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\SubscriberInterface;
use Svatel\Code\Application\EventsFactory\AbstractEvent;
use Svatel\Code\Application\Pdo\PdoGatewayApp;
use Svatel\Code\Domain\EventMapper;
use Svatel\Code\Domain\SubscribeMapper;
use Svatel\Code\Domain\Subscriber;

final class Publisher implements PublisherInterface
{
    /**
     * @var SubscriberInterface[]
     */
    private array $subscribers;

    private ?EventMapper $eventMapper = null;
    public ?SubscribeMapper $subscribeMapper = null;

    public function __construct()
    {
        $pdo = new PdoGatewayApp();
        if (!is_null($pdo->getClient())) {
            $this->subscribeMapper = new SubscribeMapper($pdo);
            $this->eventMapper = new EventMapper($pdo);
        }
    }

    /**
     * @throws \Exception
     */
    public function subscribe(SubscriberInterface $subscriber): void
    {
        if (!is_null($this->eventMapper)) {
            $event = $this->eventMapper->findByType($subscriber->getType());
            $subscriberModel = $this->subscribeMapper->findByUserIdAndType($event->getId(), $subscriber->getId());
            if (!is_null($subscriberModel)) {
                $this->subscribeMapper->update($subscriber->getId(), $event->getId());
            } else {
                $subscriberModel = new Subscriber(
                    mt_rand(1, 100),
                    $event->getId(),
                    [$subscriber->getId()]
                );
                $this->subscribeMapper->create($subscriberModel);
            }
        } else {
            $this->subscribers[] = $subscriber;
        }
    }

    public function notify(AbstractEvent $event): void
    {
        if (!is_null($this->eventMapper)) {
            $eventModel = $this->eventMapper->findByType($event->getTitle());
            $subscribers = $this->subscribeMapper->findByUserIdAndType($eventModel->getId())->getUsers();

            foreach ($subscribers as $subscriber) {
                switch ($event->getTitle()) {
                    case $event->getTitle() == 'sport':
                        $this->subscribers[] = new SportSubscriber($subscriber);
                        break;
                    case $event->getTitle() == 'concert':
                        $this->subscribers[] = new ConcertSubscriber($subscriber);
                        break;
                    case $event->getTitle() == 'exhibition':
                        $this->subscribers[] = new ExhibitionSubscriber($subscriber);
                        break;
                    case $event->getTitle() == 'concert_exhibition':
                        $this->subscribers[] = new ConcertExhibitionSubscriber($subscriber);
                        break;
                    default:
                        throw new \Exception('Неверный тип');
                }
            }
        }
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event, $subscriber->getId());
        }
    }
}
