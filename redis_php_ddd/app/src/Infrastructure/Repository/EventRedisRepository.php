<?php

namespace App\Ddd\Infrastructure\Repository;

use App\Ddd\Application\Repository;
use App\Ddd\Domain\Event;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Predis\Client;
use WS\Utils\Collections\CollectionFactory;
use WS\Utils\Collections\MapEntry;
use WS\Utils\Collections\MapFactory;

class EventRedisRepository implements Repository
{

    private const EVENTS_KEY = 'events';

    private Client $client;
    private JsonDecoder $decoder;

    public function __construct(JsonDecoder $decoder)
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => 6379,
        ]);
        $this->decoder = $decoder;
    }

    /**
     * @param Event $model
     */
    public function add($model): bool
    {
        if ($this->client->exists($model->getId())) {
            return false;
        }
        $this->client->sadd(self::EVENTS_KEY, [$model->getId()]);
        $this->client->hset($model->getId(), Event::NAME_FIELD, $model->getName());
        $this->client->hset($model->getId(), Event::PRIORITY_FIELD, $model->getPriority());
        $this->client->hset($model->getId(), Event::CONDITIONS_FIELD, $model->getConditions());

        return (bool)$this->client->exists($model->getId());
    }

    public function get($request): Event
    {
        $events = $this->client->smembers(self::EVENTS_KEY);

        return CollectionFactory::from($events)
            ->stream()
            ->filter(function (string $eventId) use ($request) {
                $conditions = $this->decoder->toArray($this->client->hget($eventId, Event::CONDITIONS_FIELD));
                return $this->isMatches($conditions, $request);
            })
            ->map(function (string $eventId) {
                return Event::create()
                    ->setId($eventId)
                    ->setName($this->client->hget($eventId, Event::NAME_FIELD))
                    ->setPriority($this->client->hget($eventId, Event::PRIORITY_FIELD))
                    ->setConditions($this->client->hget($eventId, Event::CONDITIONS_FIELD));
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
        $events = $this->client->smembers(self::EVENTS_KEY);

        $this->client->srem(self::EVENTS_KEY, $events);
        CollectionFactory::from($events)
            ->stream()
            ->each(function (string $eventId) {
                $this->client->hdel($eventId, [
                    Event::NAME_FIELD,
                    Event::PRIORITY_FIELD,
                    Event::CONDITIONS_FIELD
                ]);
            });
    }
}