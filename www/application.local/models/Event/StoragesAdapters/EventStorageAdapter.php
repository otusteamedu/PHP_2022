<?php

namespace app\models\Event\StoragesAdapters;

use app\models\Event\EventModel;

abstract class EventStorageAdapter {
    public EventModel $model;
    public string $prefix = 'event';

    public function __construct(EventModel $eventModel) {
        $this->model = $eventModel;
        $this->setStorageClient();
    }

    public function save(): bool { return false; }
    public function deleteAll(): int { return 0; }
    public function find(array $conditions): array { return []; }
    public function setStorageClient(): void {}
}
