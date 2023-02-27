<?php

declare(strict_types=1);

namespace App\EventsStorage\Memcached;

use App\EventsStorage\EventsStorageInterface;
use Exception;
use Memcached;

class MemcachedEventsStorage implements EventsStorageInterface
{
    private Memcached $memcached;

    public function __construct(array $config)
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer($config['host'], $config['port']);
    }

    /**
     * @throws Exception
     */
    public function testConnection(): string
    {
        $key = 'TEST:' . bin2hex(random_bytes(10));
        $value = 'test';
        $this->memcached->add($key, $value);
        $message = $this->memcached->get($key) === $value ? 'Success connected to Memcached' : 'Failed to connect to Memcached';
        $this->memcached->delete($key);

        return $message;
    }

    public function addEvent(string $event, string $priority, ...$conditions): bool
    {
        $result = $this->memcached->set($event, $conditions);

        foreach ($conditions as $condition) {
            if (!$result) {
                break;
            }
            $currentRecord = $this->memcached->get($condition);
            if (!empty($currentRecord)) {
                $currentRecord += [$priority => $event];
                $this->memcached->delete($condition);
                $this->memcached->set($condition, $currentRecord);
            } else {
                $result = $this->memcached->set($condition, [$priority => $event]);
            }
        }
        return $result;
    }

    public function getEvent(...$conditions): string
    {
        $validEvents = [];
        foreach ($conditions as $condition) {
            $events = $this->memcached->get($condition);

            foreach ($events as $priority => $event) {
                $eventConditions = $this->memcached->get($event);
                if (!empty($eventConditions) && empty(array_diff($eventConditions, $conditions))) {
                    $validEvents[$priority] = $event;
                }
            }
        }

        ksort($validEvents, SORT_DESC);
        return !empty($validEvents) ? array_pop($validEvents) : '';
    }

    public function flushAll(): void
    {
        $this->memcached->flush();
    }
}
