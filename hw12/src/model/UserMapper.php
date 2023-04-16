<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw12\Model;

use Veraadzhieva\Hw12\Model\User;
use PDO;

class UserMapper
{
    private $connection;

    public function __construct($host, $database) {
        $this->connection = new PDO("mysql:host=$host;dbname=$database");
    }


    /**
     * Создание нового пользователя.
     *
     * @param string $username
     * @param int $phone
     */
    public function insert($username, $phone)
    {
        return new User($username, $phone);
    }

    /**
     * Обновление пользователя.
     *
     * @param User $user
     */
    public function update(User $user)
    {
        $query = 'UPDATE users SET username=?,phone=? WHERE id=?';
        $this->connection->query($query,
            array(
                $user->getUsername(),
                $user->getPhone(),
                $user->getId()
        ));
    }

    /**
     * Удаление пользователя из бд.
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        $query = 'DELETE FROM users WHERE id = ?';
        $this->connection->query($query, array($user->getId()));
    }

    /**
     * Поиск пользователя по id.
     *
     * @param int $userId
     * @return User|null
     */
    public function findById($userId)
    {
        $sql = "SELECT id, username, phone FROM users WHERE id = ?";

        $data = $this->connection->fetchRow($sql, array($userId), Zend_Db::FETCH_ASSOC);

        $user = null;

        if ($data != false)
        {
            $user = $this->insert($data);
        }

        return $user;
    }
}