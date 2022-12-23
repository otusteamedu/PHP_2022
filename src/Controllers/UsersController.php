<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Controllers;

use Eliasjump\HwStoragePatterns\Kernel\Response;
use Eliasjump\HwStoragePatterns\Models\User\User;
use Eliasjump\HwStoragePatterns\Models\User\UserIdentityMap;
use Eliasjump\HwStoragePatterns\Models\User\UserMapper;

class UsersController extends BaseController
{
    private UserMapper $userMapper;
    private UserIdentityMap $userIdentityMap;

    public function __construct()
    {
        parent::__construct();
        $this->userMapper = new UserMapper();
        $this->userIdentityMap = UserIdentityMap::getInstance();
    }

    public function index(): string
    {
        $users = $this->userMapper->all();
        $users = array_map(function (User $user) {
            $this->userIdentityMap->addUser($user);
            return $user->toArray();
        }, $users);

        return Response::json(200, $users);
    }

    public function create(): string
    {
        $name = $this->request->getPostParameter('name');
        $email = $this->request->getPostParameter('email');

        $user = new User(name: $name, email: $email);
        $user = $this->userMapper->save($user);

        $this->userIdentityMap->addUser($user);

        return Response::json(200, $user->toArray());
    }

    public function read(): string
    {
        $userId = $this->request->getGetParameter('id');
        $user = $this->userIdentityMap->getUser($userId);
        if (!$user->id) {
            $user = $this->userMapper->findById($userId);
        }

        return Response::json(200, $user->toArray());
    }

    public function update(): string
    {
        $userId = $this->request->getPostParameter('id');
        $name = $this->request->getPostParameter('name');
        $email = $this->request->getPostParameter('email');

        $user = new User(id: (int)$userId);

        if (!is_null($name)) {
            $user->name = $name;
        }
        if (!is_null($email)) {
            $user->email = $email;
        }

        $user = $this->userMapper->update($user);
        $this->userIdentityMap->addUser($user);

        return Response::json(200, $user->toArray());
    }

    public function delete(): string
    {
        $userId = $this->request->getPostParameter('id');
        $this->userMapper->destroy($userId);
        $this->userIdentityMap->unsetUser($userId);

        return Response::json(200);
    }
}