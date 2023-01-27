<?php

namespace App\Ddd\Infrastructure\Repository;

use App\Ddd\Application\Repository;
use App\Ddd\Domain\Event;
use Predis\Client;
use WS\Utils\Collections\CollectionFactory;

class EventRedisRepository implements Repository
{

    private const EVENTS_KEY = 'events';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => 6379,
        ]);
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

    /**
     * @return Event[]
     */
    public function getAll(): array
    {
        $eventsIds = $this->client->smembers(self::EVENTS_KEY);

        return CollectionFactory::from($eventsIds)
            ->stream()
            ->map(function (string $eventId) {
                return Event::create()
                    ->setId($eventId)
                    ->setName($this->client->hget($eventId, Event::NAME_FIELD))
                    ->setPriority($this->client->hget($eventId, Event::PRIORITY_FIELD))
                    ->setConditions($this->client->hget($eventId, Event::CONDITIONS_FIELD));
            })
            ->toArray();
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