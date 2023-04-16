<?php

declare(strict_types = 1);

use Veraadzhieva\Hw12;
use Veraadzhieva\Hw12\Model\User;
use Veraadzhieva\Hw12\Model\UserMapper;

class UserController
{
    private $mapper;

    public function __construct($host, $database) {
        $this->mapper = new UserMapper($host, $database);
    }

    public function insertUser($params) {
        try {
            $this->mapper->insert($params['username'], $params['phone']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUser(User $user) {
        try {
            $this->mapper->update($user);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteUser(User $user) {
        try {
            $this->mapper->delete($user);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectUserById($id) {
        try {
            $this->mapper->findById($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}