<?php

declare(strict_types=1);

namespace Otus\App\Model;

use JsonException;
use Otus\App\Controller\StorageController;

class Repository
{
    protected StorageController $storageController;

    public function __construct()
    {
        $this->storageController = new StorageController();
    }

    public function saveEvent($event): bool
    {
        $event = json_decode(urldecode($event), true, 512, JSON_THROW_ON_ERROR);

        if (!$event) {
            throw new \RuntimeException('Error. Format of event is wrong.');
        }

        $eventModel = new Event($event);
        return $this->storageController->saveEvent($eventModel);
    }

    public function deleteEvents(): bool
    {
        return $this->storageController->deleteEvents(Event::KEY);
    }

    public function getEvent($params): array
    {
        $params = json_decode(urldecode($params), true, 512, JSON_THROW_ON_ERROR);

        if (!$params || !$params['params']) {
            throw new \RuntimeException('Error. Format of params are wrong.');
        }

        return $this->storageController->getEvent($params['params']);
    }
}
