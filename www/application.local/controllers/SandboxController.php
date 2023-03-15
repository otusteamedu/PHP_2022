<?php

namespace app\controllers;

use app\models\User\User;
use app\models\User\UserIdentityMap;
use app\models\User\UserMapper;

class SandboxController {

    public function run (): string {
        $id = uniqid('id');

        $newUserData = [
            'id' => $id,
            'name' => uniqid('name'),
            'surname' => uniqid('surname'),
        ];

        $userMapper = new UserMapper();
        $userMapper->insert($newUserData);

        $found1 = $userMapper->findById($id);
        $found2 = $userMapper->findById($id);

        $return = 'Записи, полученные из базы двумя запросами по одному id, '.($found1 === $found2 ? 'идентичны' : 'не идентичны.');

        $found3 = $this->getUser($id);
        $found4 = $this->getUser($id);

        $return .= PHP_EOL.'Записи, полученные с помощью Identity Map, '.($found3 === $found4 ? 'идентичны' : 'не идентичны.');

        $return .= PHP_EOL.'Работа с БД проведена успешно';
        return $return;
    }

    public function getUser(string $id): ?User {
        $iMap = UserIdentityMap::getInstance();
        if (!$user = $iMap::getUser($id)) {
            $userMapper = new UserMapper();
            $user = $userMapper->findById($id);
            $iMap::addUser($user);
        }
        return $user;
    }

}
