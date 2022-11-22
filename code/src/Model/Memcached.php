<?php

declare(strict_types=1);

namespace Otus\App\Model;

use JsonException;
use Otus\App\App;
use Memcached as Client;
use Otus\App\Interfaces\StorageInterface;



class Memcached implements StorageInterface
{
    protected Client $memcached;

    public function __construct()
    {
        $config = App::getConfig();

        $this->memcached = new Client();
        $this->memcached->addServer(host: $config['repository']['memcached_host'],
                                    port: (int) $config['repository']['memcached_port']
        );
    }

    public function saveEvent(Event $event): bool
    {
        $id = $event->getId();

        $already_added_data = $this->memcached->get(key: $id) ?: [];

        $new_data = array_merge(
            $already_added_data,
            [json_decode(json: $event->getEventDataForMemcached(), associative: true)]
        );

        $result = $this->memcached->replace(key: $id, value: $new_data);

        if (!$result) {
            $this->memcached->set(key: $id, value: $new_data);
        }

        return true;

    }

    public function getEvent(array $params): array
    {
        // TODO: Implement getEvent() method. Now message - Error. Event is not found.
        // TODO:

        $event = [];
        if (!($events = $this->memcached->get(Event::KEY))) {
            return $event;
        }
        return $events;
    }

    public function deleteEvents(string $key): bool
    {
        $this->memcached->flush();

        return true;

    }
}
