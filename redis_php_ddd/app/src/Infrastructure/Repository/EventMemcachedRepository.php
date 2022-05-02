<?php

namespace App\Ddd\Infrastructure\Repository;

use App\Ddd\Application\Repository;
use App\Ddd\Domain\Event;
use Memcached;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use WS\Utils\Collections\CollectionFactory;

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

    /**
     * @return Event[]
     */
    public function getAll(): array
    {
        $events = $this->client->get(self::EVENTS_KEY) ?: [];
        return CollectionFactory::from($events)
            ->stream()
            ->map(function (string $eventId) {
                $event = $this->decoder->toArray($this->client->get($eventId));
                return Event::create()
                    ->setId($eventId)
                    ->setName($event['name'])
                    ->setPriority($event['priority'])
                    ->setConditions($this->decoder->toJson($event['conditions']));
            })
            ->toArray();
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
