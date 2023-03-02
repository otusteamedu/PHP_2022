<?php

declare(strict_types=1);

namespace App\Application\EventSystem\EventSubscriber\NewLK;

use App\Application\EventSystem\Event\DealStateChangedEvent;
use App\Application\Messenger\NewLK\Message\ChangeDealStateMessage;
use App\Application\UseCase\Bank\DealStateMapperResolver;
use new\Domain\Enum\NewLK\DealState;
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
        $dealStateMapper = DealStateMapperResolver::getMapperByBank($event->getDeal()->getBank(), $event->getDeal());
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
