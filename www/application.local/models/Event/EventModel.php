<?php

namespace app\models\Event;

use app\models\Event\StoragesAdapters\EventRedisAdapter;
use app\models\Model;

class EventModel extends Model {
    public $priority; // не указан тип, чтобы не приводилось к инту при ошибке
    public array $conditions;
    public array $event;
    public EventRedisAdapter $storageAdapter;

    public function __construct(array $from = [])
    {
        parent::__construct($from);
        $this->setStorageAdapter();
    }

    public function validate(): bool {
        if (!$this->priority || !is_int($this->priority)) $this->errors[] = 'Отсутствует параметр priority';
        if (empty($this->conditions)) $this->errors[] = 'Отсутствует параметр conditions';
        if (!$this->event || !$this->event['payload']) $this->errors[] = 'Отсутствует параметр event или его payload';
        return empty($this->errors);
    }

    public function save() {
        $this->storageAdapter->save();
    }

    public function setStorageAdapter() {
        $this->storageAdapter = new EventRedisAdapter($this);
    }

    private function validateFindQuery($conditions) {
        if (!is_array($conditions)) {
            throw new \Exception('Запрос должен быть массивом', 400);
        }
    }

    public function find($conditions) {
        $this->validateFindQuery($conditions);
        return $this->storageAdapter->find($conditions);
    }

    public function findPriorityOne($conditions) {
        $items = $this->find($conditions);
        if (count($items) === 0) return [];
        elseif (count($items) === 1) return $items[0];

        usort($items, function ($a, $b){
            if ($a['priority'] === $b['priority']) return 0;
            return ($a['priority'] > $b['priority']) ? -1 : 1;
        });

        return $items;
    }

    public function deleteAll() {
        return $this->storageAdapter->deleteAll();
    }

}
