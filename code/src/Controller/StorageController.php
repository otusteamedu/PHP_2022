<?php

namespace KonstantinDmitrienko\App\Controller;

use JsonException;
use KonstantinDmitrienko\App\Model\Redis;

/**
 * StorageController
 */
class StorageController
{
    /**
     * @var Redis
     */
    protected Redis $storage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storage = new Redis();
    }

    /**
     * @param $event
     *
     * @return bool
     */
    public function saveEvent($event): bool
    {
        return $this->storage->saveEvent($event);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function deleteEvents(string $key): bool
    {
        return $this->storage->deleteEvents($key);
    }

    /**
     * @throws JsonException
     */
    public function getEvent($params): array
    {
        return $this->storage->getEvent($params);
    }
}
