<?php

namespace app\models\Event\StoragesAdapters;

use app\storages\Redis;
use Predis\Client;

class EventRedisAdapter extends EventStorageAdapter {
    use Redis;
    public Client $client;

    public function save(): bool
    {
        $id = uniqid($this->prefix);
        $this->client->transaction(function ($tx) use ($id) {
            foreach ($this->model->conditions as $param => $value) {
                $key = $this->prefix.':cond:'.$param.':'.$value;
                $tx->sadd($this->prefix.':cond:'.$param.':'.$value, [$id]);
                $tx->sadd($this->prefix.':keys', $key);
            }

            $tx->hset($id, 'priority', $this->model->priority);
            foreach ($this->model->conditions as $condKey => $condVal) {
                $tx->hset($id, 'conditions:'.$condKey, $condVal);
            }
            $tx->hset($id, 'event:payload', $this->model->event['payload']);
            $tx->sadd($this->prefix.':keys', $id);
        });

        return true;
    }


    public function deleteAll(): int
    {
        $key = $this->prefix.':keys';
        $keys = $this->client->smembers($this->prefix.':keys');
        $keys[] = $key;
        return $this->client->del($keys);
    }

    public function find(array $conditions): array {
        $sets = [];
        foreach ($conditions as $condKey => $condVal) {
            $sets[] = $this->prefix.':cond:'.$condKey.':'.$condVal;
        }

        $ids = $this->client->sinter($sets);
        $result = [];
        foreach ($ids as $id) {
            $result[] = $this->client->hgetall($id);
        }
        return $result;
    }

}
