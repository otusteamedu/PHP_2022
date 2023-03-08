<?php

namespace Models;

use Domain\Contracts\Repository\UserRepositoryInterface;

class Users extends Model implements UserRepositoryInterface
{
    protected $table = 'users';

    /**
     * @param string $username
     * @return array
     */
    public function getUserByUsername(string $username): array
    {
        db()->autoConnect();

        return db()
            ->query(sql: 'SELECT * FROM ' . $this->table)
            ->where('username', $username)
            ->first();
    }
}
