<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Storages;

use Memcached;

class MemcachedStorage implements StorageInterface
{
    private Memcached $memcached;

    public function __construct()
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer("memcached", 11211);
    }

    public function add(array $conditions, string $event, int $score): void
    {
        $preparedConditions = $this->conditionsToString($conditions);

        $this->memcached->set($preparedConditions, ['event' => $event, 'score' => $score], 60 * 60 * 24 * 5);
    }

    public function get(array $conditions): string|null
    {
        $preparedConditions = $this->conditionsToString($conditions);

        $conditions = $this->memcached->getAllKeys();

        $result = [
            'event' => null,
            'score' => -1
        ];
        foreach ($conditions as $condition) {
            if (str_contains($condition, $preparedConditions)) {
                $currentEvent = $this->memcached->get($condition);
                if ($currentEvent['score'] > $result['score']) {
                    $result = $currentEvent;
                }
            }
        }

        return $result['event'];
    }

    public function truncate(): void
    {
        $this->memcached->flush();
    }

    private function conditionsToString(array $conditions): string
    {
        $conditions = array_map(fn($key, $item) => "$key:$item", array_keys($conditions), $conditions);

        return implode('::', $conditions);
    }
}
