<?php

namespace Redis\App\Repository;

use Memcached;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Redis\App\Model\Event;
use WS\Utils\Collections\CollectionFactory;
use WS\Utils\Collections\MapEntry;
use WS\Utils\Collections\MapFactory;

class EventMemcachedRepository implements Repository
{
    private const EVENTS_KEY = 'events';

    private Memcached $client;
    private JsonDecoder $decoder;

    public function __construct(JsonDecoder $decoder)
    {
        $this->client = new Memcached();
        $this->client->addServer('memcached', 11211, 30);
        $this->decoder = $decoder;
    }

    /**
     * @param Event $model
     */
    public function add($model): bool
    {
        $events = $this->client->get(self::EVENTS_KEY) ?: [];
        $events[] = $model->getId();
        $this->client->set(self::EVENTS_KEY, $events);

        return $this->client->set($model->getId(), $model->jsonSerialize());
    }

    public function get($request): ?Event
    {
        $events = $this->client->get(self::EVENTS_KEY) ?: [];
        return CollectionFactory::from($events)
            ->stream()
            ->filter(function (string $eventId) use ($request) {
                $event = $this->decoder->toArray($this->client->get($eventId));
                $conditions = $event['conditions'];
                return $this->isMatches($conditions, $request);
            })
            ->map(function (string $eventId) {
                $event = $this->decoder->toArray($this->client->get($eventId));
                return Event::create()
                    ->setId($eventId)
                    ->setName($event['name'])
                    ->setPriority($event['priority'])
                    ->setConditions($this->decoder->toJson($event['conditions']));
            })
            ->sortByDesc(function (Event $event) {
                return $event->getPriority();
            })
            ->findFirst();
    }

    private function isMatches(array $conditions, array $request): bool
    {
        return count($conditions) === MapFactory::assoc($request)
                ->stream()
                ->filter(function (MapEntry $entry) use ($conditions) {
                    return array_key_exists($entry->getKey() , $conditions)
                        && $entry->getValue() === $conditions[$entry->getKey()];
                })
                ->getCollection()
                ->size();
    }

    public function delete(): void
    {
        $events = $this->client->get(self::EVENTS_KEY) ?: [];
        $this->client->delete(self::EVENTS_KEY);
        CollectionFactory::from($events)
            ->stream()
            ->each(function (string $eventId) {
                $this->client->delete($eventId);
            });
    }
}
