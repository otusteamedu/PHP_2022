<?php

declare(strict_types=1);

use Kogarkov\Es\Core\Service\Response;
use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Model\UserModel;
use Kogarkov\Es\Core\Storage\Mysql\Query\User as UserQuery;

class UserController
{
    private $request;

    public function __construct()
    {
        $this->request = Registry::instance()->get('request');
    }

    public function index(): void
    {
        // TODO: Think about default methods
        $response = new Response();
        $response->setData(['message' => 'Hello!'])->asJson()->isOk();
    }

    public function getOne(): void
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'GET') {
            throw new \Exception('Method not allowed');
        }

        if (empty($this->request->get['id'])) {
            throw new Exception('Request params is empty');
        }

        $query = new UserQuery();
        $result = $query->findOne((int)$this->request->get['id']);
        
        $response = new Response();
        if ($result) {
            $response->setData(['user' => $result])->asJson()->isOk();
        } else {
            throw new \Exception('Users not found');
        }
    }
    
    public function getAll(): void
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'GET') {
            throw new \Exception('Method not allowed');
        }

        $query = new UserQuery();
        $result = $query->getAll();
        
        $response = new Response();
        if ($result) {
            $response->setData(['users' => $result])->asJson()->isOk();
        } else {
            throw new \Exception('Users not found');
        }
    }

    public function add(): void
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception('Method not allowed');
        }

        $model = new UserModel();
        $user = $model->fromJson($this->request->raw_post);

        $query = new UserQuery();
        $result = $query->create($user);
        
        $response = new Response();
        if ($result) {
            $response->setData(['message' => 'User added'])->asJson()->isOk();
        } else {
            throw new \Exception('User not added');
        }
    }

    public function update(): void
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'PUT') {
            throw new \Exception('Method not allowed');
        }

        $model = new UserModel();
        $user = $model->fromJson($this->request->raw_post);

        $query = new UserQuery();
        $result = $query->update($user);
        
        $response = new Response();
        if ($result) {
            $response->setData(['message' => 'User updated'])->asJson()->isOk();
        } else {
            throw new \Exception('Nothing to update');
        }
    }

    public function delete(): void
    {
        if ($this->request->server['REQUEST_METHOD'] !== 'DELETE') {
            throw new \Exception('Method not allowed');
        }
        
        if (empty($this->request->get['id'])) {
            throw new Exception('Request params is empty');
        }
       
        $query = new UserQuery();
        $result = $query->delete((int)$this->request->get['id']);

        $response = new Response();
        if ($result) {
            $response->setData(['message' => 'User deleted'])->asJson()->isOk();
        } else {
            throw new \Exception('Nothing to delete');
        }
    }
}
