<?php

namespace App\Ddd\Application;

use App\Ddd\Domain\Event;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use WS\Utils\Collections\CollectionFactory;
use WS\Utils\Collections\MapEntry;
use WS\Utils\Collections\MapFactory;

class EventService
{
    private Repository $repository;
    private JsonDecoder $decoder;

    public function __construct(RepositoryFactory $repositoryFactory, JsonDecoder $decoder)
    {
        $this->decoder = $decoder;
        $this->repository = $repositoryFactory->create();
    }

    public function addEvent(Event $event): bool
    {
        return $this->repository->add($event);
    }

    public function deleteEvents(): void
    {
        $this->repository->delete();
    }

    public function getEvent(array $request): ?Event
    {
        $events = $this->repository->getAll();
        return CollectionFactory::from($events)
            ->stream()
            ->filter(function (Event $event) use ($request) {
                return $this->isMatches($event->getConditions(), $request);
            })
            ->sortByDesc(function (Event $event) {
                return $event->getPriority();
            })
            ->findFirst();
    }

    private function isMatches(string $conditions, array $request): bool
    {
        $eventConditions = $this->decoder->toArray($conditions);
        return count($eventConditions) === MapFactory::assoc($request)
                ->stream()
                ->filter(function (MapEntry $entry) use ($eventConditions) {
                    return array_key_exists($entry->getKey(), $eventConditions)
                        && $entry->getValue() === $eventConditions[$entry->getKey()];
                })
                ->getCollection()
                ->size();
    }
}
