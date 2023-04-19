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

    /**
     * @throws \Exception
     */
    public function subscribe(SubscriberInterface $subscriber): void
    {
        switch ($subscriber) {
            case $subscriber->getType() == 'sport':
                $type = 'sport';
                break;
            case $subscriber->getType() == 'concert':
                $type = 'concert';
                break;
            case $subscriber->getType() == 'exhibition':
                $type = 'exhibition';
                break;
            case $subscriber->getType() == 'concert_exhibition':
                $type = 'concert_exhibition';
                break;
            default:
                throw new \Exception('Неверный тип');
        }
        $pdo = new PdoGatewayApp();
        $mapperSubscriber = new SubscribeMapper($pdo);
        $mapperEvent = new EventMapper($pdo);
        $event = $mapperEvent->findByType($type);
        $subscriberModel = $mapperSubscriber->findByUserIdAndType($event->getId(), $subscriber->getId());
        if (!is_null($subscriberModel)) {
            $mapperSubscriber->update($subscriber->getId(), $event->getId());
        } else {
            $subscriberModel = new Subscriber(
                mt_rand(1, 100),
                $event->getId(),
                [$subscriber->getId()]
            );
            $mapperSubscriber->create($subscriberModel);
        }
    }

    public function notify(AbstractEvent $event): void
    {
        $pdo = new PdoGatewayApp();
        $mapperSubscriber = new SubscribeMapper($pdo);
        $mapperEvent = new EventMapper($pdo);
        $eventModel = $mapperEvent->findByType($event->getTitle());
        $subscribers = $mapperSubscriber->findByUserIdAndType($eventModel->getId())->getUsers();

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

        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event, $subscriber->getId());
        }
    }
}
