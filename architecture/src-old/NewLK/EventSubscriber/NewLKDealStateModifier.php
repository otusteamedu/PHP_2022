<?php

declare(strict_types=1);

namespace App\NewLK\EventSubscriber;

use App\Bank\Common\Factory\DealStateMapperFactory;
use App\Event\DealStateChangedEvent;
use App\NewLK\Enum\DealState;
use App\NewLK\Messenger\Message\ChangeDealStateMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Ловит событие по изменению статуса и отправляет новый статус в NewLk
 */
class NewLKDealStateModifier implements EventSubscriberInterface
{
    public function __construct(private readonly MessageBusInterface $bankApplicationBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DealStateChangedEvent::class => [
                ['onDealStateChanged', 0]
            ]
        ];
    }

    public function onDealStateChanged(DealStateChangedEvent $event): void
    {
        $dealStateMapper = DealStateMapperFactory::getMapperByBank($event->getDeal()->getBank(), $event->getDeal());
        $dealState = $dealStateMapper->getByBankApplicationState($event->getBankApplicationState());
        if ($dealState === DealState::SENT) {
            return;
        }

        $message = new ChangeDealStateMessage(
            $event->getDeal()->getApplicationUuid()->toString(),
            $event->getDeal()->getInternalId()->toString(),
            $event->getDeal()->getBank()->getInternalId(),
            $dealState,
            $event->getComment()
        );
        $this->bankApplicationBus->dispatch($message);
    }
}
