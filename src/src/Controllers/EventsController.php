<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Controllers;

use Eliasjump\HwRedis\Storages\MemcachedStorage;
use Eliasjump\HwRedis\Storages\RedisStorage;
use Eliasjump\HwRedis\Storages\StorageInterface;

class EventsController extends BaseController
{
    private StorageInterface $storage;

    public function __construct()
    {
        parent::__construct();
        $this->storage = new RedisStorage();
    }

    public function create(): string
    {
        $event = $this->request->getPostParameter('event');
        $score = (int)$this->request->getPostParameter('score');
        $conditions = $this->request->getPostParameter('conditions');
        $this->storage->add($conditions, $event, $score);
        return $this->response(200);
    }

    public function truncate(): string
    {
        $this->storage->truncate();
        return $this->response(200);
    }

    public function show(): string
    {
        $conditions = $this->request->getPostParameter('conditions');
        $res = $this->storage->get($conditions);
        return $this->response(200, ['event' => $res]);
    }
}
