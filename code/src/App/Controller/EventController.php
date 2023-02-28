<?php

declare(strict_types=1);

use Kogarkov\Es\Core\Service\Response;
use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Core\Storage\Redis\Query\Event as EventQuery;
use Kogarkov\Es\Core\Storage\Redis\Core as RManager;
use Kogarkov\Es\Model\EventModel;

class EventController
{
    private $request;

    public function __construct()
    {
        $this->request = Registry::instance()->get('request');
    }

    public function index()
    {
        $response = new Response();
        $response->setData($this->request->get)->asJson()->isOk();
    }

    public function getOne()
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'GET') {
            throw new \Exception('Method not allowed');
        }

        if (empty($this->request->get)) {
            throw new Exception('Request params is empty');
        }

        $client = new RManager();
        $query = new EventQuery($client->get());
        $result = $query->getOne($this->request->get);
        
        $response = new Response();
        if ($result) {
            $response->setData(['event' => $result])->asJson()->isOk();
        } else {
            throw new \Exception('Events not found');
        }
    }
    
    public function getAll()
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'GET') {
            throw new \Exception('Method not allowed');
        }

        $client = new RManager();
        $query = new EventQuery($client->get());
        $result = $query->getAll();
        
        $response = new Response();
        if ($result) {
            $response->setData(['events' => $result])->asJson()->isOk();
        } else {
            throw new \Exception('Events not found');
        }
    }

    public function add()
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception('Method not allowed');
        }

        $model = new EventModel();
        $event = $model->fromJson($this->request->raw_post);

        $client = new RManager();
        $query = new EventQuery($client->get());
        $result = $query->add($event);
        
        $response = new Response();
        if ($result) {
            $response->setData(['message' => 'Event added'])->asJson()->isOk();
        } else {
            throw new \Exception('Event not added');
        }
    }

    public function clear()
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'DELETE') {
            throw new \Exception('Method not allowed');
        }

        $client = new RManager();
        $query = new EventQuery($client->get());
        $result = $query->deleteAll();

        $response = new Response();
        if ($result) {
            $response->setData(['message' => 'All events deleted'])->asJson()->isOk();
        } else {
            throw new \Exception('Nothing to delete');
        }
    }
}
