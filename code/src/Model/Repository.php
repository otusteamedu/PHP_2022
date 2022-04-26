<?php

namespace KonstantinDmitrienko\App\Model;

use JsonException;
use KonstantinDmitrienko\App\Controller\StorageController;

/**
 * Repository
 */
class Repository
{
    /**
     * @var StorageController
     */
    protected StorageController $storageController;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storageController = new StorageController();
    }

    /**
     * @throws JsonException
     */
    public function saveEvent($event): bool
    {
        $event = json_decode(urldecode($event), true, 512, JSON_THROW_ON_ERROR);

        if (!$event) {
            throw new \RuntimeException('Error. Format of event is wrong.');
        }

        $eventModel = new Event($event);
        return $this->storageController->saveEvent($eventModel);
    }

    /**
     * @return bool
     */
    public function deleteEvents(): bool
    {
        return $this->storageController->deleteEvents(Event::KEY);
    }

    /**
     * @throws JsonException
     */
    public function getEvent($params): array
    {
        $params = json_decode(urldecode($params), true, 512, JSON_THROW_ON_ERROR);

        if (!$params || !$params['params']) {
            throw new \RuntimeException('Error. Format of params are wrong.');
        }

        return $this->storageController->getEvent($params['params']);
    }
}
