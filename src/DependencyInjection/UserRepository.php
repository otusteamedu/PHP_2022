<?php

namespace Patterns\DependencyInjection;

class UserRepository
{

    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function getUsers(): string
    {
        return $this->db->connect() . PHP_EOL . 'Получение пользователей....';
    }
}
