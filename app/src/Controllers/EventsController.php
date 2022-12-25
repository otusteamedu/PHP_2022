<?php

namespace Octopus\App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Octopus\App\Storage\RedisStorage;

class EventsController
{
    private RedisStorage $storage;

    public function __construct()
    {
        $this->storage = new RedisStorage();
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = json_decode($request->getBody()->getContents(), true);
        $event = $params['event'] ?? null;
        $priority = $params['priority'] ?? null;
        $conditions = $params['conditions'] ?? null;

        $this->storage->add($conditions, $event, $priority);
    }

//    public function truncate(): string
//    {
//        $this->storage->truncate();
//        return Response::json(200);
//    }
//
//    public function show(): string
//    {
//        $conditions = $this->request->getPostParameter('conditions');
//        $res = $this->storage->get($conditions);
//        return Response::json(200, ['event' => $res]);
//    }
}
